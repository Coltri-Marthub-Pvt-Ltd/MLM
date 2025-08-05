<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewOpportunity;
use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\Location;

class NewOpportunityController extends Controller
{
    public function index()
    {
        $opportunities = NewOpportunity::with(['badge', 'location'])
            ->orderBy('order', 'asc')
            ->get();
    $badges = Badge::all(); // Add this line
    $locations = Location::all(); // Add this line
    
    return view('admin.new-opportunities.index', compact('opportunities', 'badges', 'locations'));
}

    public function create()
    {
        return view('admin.new-opportunities.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'badge_id' => 'required|exists:badges,id',
        'location_id' => 'required|exists:locations,id',
        'project_name' => 'required|string|max:255',
        'area' => 'required|string|max:255',
        'client_name' => 'required|string|max:255',
        'client_phone' => 'required|string|max:20',
        'order' => 'required|integer',
    ]);

    NewOpportunity::create($validated);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'New opportunity created successfully.'
        ]);
    }

    return redirect()->route('admin.new-opportunities.index')
        ->with('success', 'New opportunity created successfully.');
}

public function update(Request $request, NewOpportunity $newOpportunity)
{
    $validated = $request->validate([
        'badge_id' => 'required|exists:badges,id',
        'location_id' => 'required|exists:locations,id',
        'project_name' => 'required|string|max:255',
        'area' => 'required|string|max:255',
        'client_name' => 'required|string|max:255',
        'client_phone' => 'required|string|max:20',
        'order' => 'required|integer',
    ]);

    $newOpportunity->update($validated);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Opportunity updated successfully.'
        ]);
    }

    return redirect()->route('admin.new-opportunities.index')
        ->with('success', 'Opportunity updated successfully.');
}

    public function show(NewOpportunity $newOpportunity)
    {
        return view('admin.new-opportunities.show', compact('newOpportunity'));
    }

    public function edit(NewOpportunity $newOpportunity)
    {
        return view('admin.new-opportunities.edit', compact('newOpportunity'));
    }

  

    public function destroy(NewOpportunity $newOpportunity)
    {
        $newOpportunity->delete();

        return redirect()->route('admin.new-opportunities.index')
            ->with('success', 'Opportunity deleted successfully.');
    }
}
