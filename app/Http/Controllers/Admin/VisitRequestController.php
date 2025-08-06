<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitRequest;
use Illuminate\Http\Request;
use Auth;

class VisitRequestController extends Controller
{
    public function index()
    {
        $visitRequests = VisitRequest::latest()->paginate(10);
        return view('admin.visit_requests.index', compact('visitRequests'));
    }

    public function create()
    {
        return view('admin.visit_requests.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'variant' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'city' => 'required|string|max:100', // Changed from country to city
        'address' => 'required|string',
        'order_issue' => 'required|string',
        'sampling_tokens' => 'nullable|string|max:255'
    ]);
     $validated['user_id'] = Auth::user()->id;

    VisitRequest::create($validated);

    return redirect()->route('admin.visit-requests.index')
                     ->with('success', 'Visit request created successfully.');
}

    public function show(VisitRequest $visitRequest)
    {
        return view('admin.visit_requests.show', compact('visitRequest'));
    }

public function edit(VisitRequest $visitRequest)
{
    return response()->json([
        'name' => $visitRequest->name,
        'variant' => $visitRequest->variant,
        'phone' => $visitRequest->phone,
        'city' => $visitRequest->city,
        'address' => $visitRequest->address,
        'order_issue' => $visitRequest->order_issue,
        'sampling_tokens' => $visitRequest->sampling_tokens,
    ]);
}

   public function update(Request $request, VisitRequest $visitRequest)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'variant' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'city' => 'required|string|max:100', // Changed from country to city
        'address' => 'required|string',
        'order_issue' => 'required|string',
        'sampling_tokens' => 'nullable|string|max:255'
    ]);
     $validated['user_id'] = Auth::user()->id;

    $visitRequest->update($validated);

    return redirect()->route('admin.visit-requests.index')
                     ->with('success', 'Visit request updated successfully.');
}

    public function destroy(VisitRequest $visitRequest)
    {
        $visitRequest->delete();

        return redirect()->route('admin.visit-requests.index')
                         ->with('success', 'Visit request deleted successfully.');
    }
}