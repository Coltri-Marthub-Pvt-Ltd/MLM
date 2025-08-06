<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GitDistributed;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class GitDistributedController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $distributeds = GitDistributed::with('location')->latest()->paginate(10);
        return view('admin.git_distributeds.index', compact('distributeds','locations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('admin.git_distributeds.create', compact('locations'));
    }

        public function enquery()
    {
        $locations = Location::all();
        return view('admin.enquery.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');
        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('git_distributeds', 'public');
        }

        GitDistributed::create($data);

        return redirect()->route('admin.git-distributeds.index')
            ->with('success', 'Git Distributed created successfully.');
    }

    public function show(GitDistributed $gitDistributed)
    {
        return view('admin.git_distributeds.show', compact('gitDistributed'));
    }

    public function edit(GitDistributed $gitDistributed)
    {
        $locations = Location::all();
        return response()->json([
        'data' => $gitDistributed,
        'locations' => Location::all()
    ]);
    }

    public function update(Request $request, GitDistributed $gitDistributed)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gitDistributed->image) {
                Storage::disk('public')->delete($gitDistributed->image);
            }
            $data['image'] = $request->file('image')->store('git_distributeds', 'public');
        }
         $data['user_id'] = Auth::user()->id;
        $gitDistributed->update($data);

        return redirect()->route('admin.git-distributeds.index')
            ->with('success', 'Git Distributed updated successfully.');
    }

    public function destroy(GitDistributed $gitDistributed)
    {
        // Delete image if exists
        if ($gitDistributed->image) {
            Storage::disk('public')->delete($gitDistributed->image);
        }

        $gitDistributed->delete();

        return redirect()->route('admin.git-distributeds.index')
            ->with('success', 'Git Distributed deleted successfully.');
    }
}