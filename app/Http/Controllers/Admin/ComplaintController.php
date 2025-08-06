<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->get();
        return view('admin.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('admin.complaints.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'supplied_material' => 'required|string|max:255',
        'date' => 'required|date',
        'city' => 'required|string|max:255',
        'address' => 'required|string',
        'visit_request' => 'required|boolean',
        'issues' => 'required|string',
        'photos' => 'required|array|min:1',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $validated['date'] = \Carbon\Carbon::parse($validated['date'])->format('Y-m-d');

    $complaint = Complaint::create($validated);

    // Handle photo uploads
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('complaints/photos', 'public');
            ComplaintPhoto::create([
                'complaint_id' => $complaint->id,
                'path' => $path
            ]);
        }
    }

    return redirect()->route('admin.complaints.index')
        ->with('success', 'Complaint created successfully.');
}

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        return view('admin.complaints.edit', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'supplied_material' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'visit_request' => 'required|boolean',
            'issues' => 'required|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Format date to d-M-Y before saving
        $validated['date'] = \Carbon\Carbon::parse($validated['date'])->format('Y-m-d');

        $complaint->update($validated);

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('complaints/photos', 'public');
                ComplaintPhoto::create([
                    'complaint_id' => $complaint->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint updated successfully.');
    }

    public function destroy(Complaint $complaint)
    {
        // Delete associated photos
        foreach ($complaint->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $complaint->delete();

        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }

    public function destroyPhoto(ComplaintPhoto $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }
}
