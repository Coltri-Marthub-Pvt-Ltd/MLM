<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Badge;
use App\Models\NewOpportunity;

class BusinessOpportunity extends Controller
{
  public function index(){
    $contractor = Auth::guard('contractor')->user();
    $currentBadge = Badge::getElagibleEarnedBadges($contractor->points);
    $badges = Badge::all();
    $opportunities = NewOpportunity::with(['badge', 'location'])
            ->orderBy('order', 'asc')
            ->get();

    return view('contractor.business_opportunity.index',compact('opportunities','currentBadge','badges'));
  }

      public function show($id)
{
    $opportunity = NewOpportunity::with(['badge', 'location'])->findOrFail($id);
    dd($opportunity);
    return response()->json($opportunity);
}
}
