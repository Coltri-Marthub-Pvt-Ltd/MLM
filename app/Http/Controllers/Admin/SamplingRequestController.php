<?php

// app/Http/Controllers/Admin/SamplingRequestController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SamplingRequest;
use Illuminate\Http\Request;
use Auth;

class SamplingRequestController extends Controller
{
    public function index()
    {
        $requests = SamplingRequest::latest()->get();
        return view('admin.sampling_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('admin.sampling_requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variant' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'contact_details' => 'required|string',
            'visit_request' => 'required|boolean',
            'other_details' => 'nullable|string'
        ]);
         $validated['user_id'] = Auth::user()->id;
        SamplingRequest::create($validated);

        return redirect()->route('admin.sampling-requests.index')
            ->with('success', 'Sampling request created successfully.');
    }

    public function show(SamplingRequest $samplingRequest)
    {
        return view('admin.sampling_requests.show', compact('samplingRequest'));
    }

    public function edit(SamplingRequest $samplingRequest)
    {
        return view('admin.sampling_requests.edit', compact('samplingRequest'));
    }

    public function update(Request $request, SamplingRequest $samplingRequest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variant' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'contact_details' => 'required|string',
            'visit_request' => 'required|boolean',
            'other_details' => 'nullable|string'
        ]);
          $validated['user_id'] = Auth::user()->id;
        $samplingRequest->update($validated);

        return redirect()->route('admin.sampling-requests.index')
            ->with('success', 'Sampling request updated successfully.');
    }

    public function destroy(SamplingRequest $samplingRequest)
    {
        $samplingRequest->delete();

        return redirect()->route('admin.sampling-requests.index')
            ->with('success', 'Sampling request deleted successfully.');
    }
}
