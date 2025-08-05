<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GitCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GitCardController extends Controller
{
    public function index()
    {
        $gitcards = GitCard::orderBy('orderBY', 'asc')->get();
        return view('admin.gitcards.index', compact('gitcards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:git_cards,name',
            'description' => 'nullable|string',
            'coins' => 'required|integer|min:0',
            'orderBY' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gitcards', 'public');
        }

        GitCard::create($data);

        return response()->json([
            'success' => true,
            'message' => 'GitCard created successfully'
        ]);
    }

    public function update(Request $request, GitCard $gitcard)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:git_cards,name,'.$gitcard->id,
            'description' => 'nullable|string',
            'coins' => 'required|integer|min:0',
            'orderBY' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'remove_image']);

        // Handle image removal
        if ($request->remove_image) {
            if ($gitcard->image) {
                Storage::disk('public')->delete($gitcard->image);
                $data['image'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gitcard->image) {
                Storage::disk('public')->delete($gitcard->image);
            }
            $data['image'] = $request->file('image')->store('gitcards', 'public');
        }

        $gitcard->update($data);

        return response()->json([
            'success' => true,
            'message' => 'GitCard updated successfully'
        ]);
    }

    public function destroy(GitCard $gitcard)
    {
        if ($gitcard->image) {
            Storage::disk('public')->delete($gitcard->image);
        }

        $gitcard->delete();

        return redirect()->route('admin.gitcards.index')->with('success', 'GitCard deleted successfully.');

    }
}