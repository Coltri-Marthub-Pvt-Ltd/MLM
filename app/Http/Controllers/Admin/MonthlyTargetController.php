<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyTarget;
use App\Models\User;
use Illuminate\Http\Request;

class MonthlyTargetController extends Controller
{
    public function index()
    {
        $targets = MonthlyTarget::with('user')->latest()->get();
        $users = User::all();
        return view('admin.monthly-targets.index', compact('targets', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'target' => 'required|numeric|min:0',
            'date' => 'required|date'
        ]);

        MonthlyTarget::create($request->all());

           return response()->json([
            'success' => true,
            'message' => 'Monthly target created successfully'
        ]);
    }

    public function update(Request $request, MonthlyTarget $monthlyTarget)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'target' => 'required|numeric|min:0',
            'date' => 'required|date'
        ]);

        $monthlyTarget->update($request->all());
           return response()->json([
            'success' => true,
            'message' => 'Monthly target updated successfully.'
        ]);
    }

    public function destroy(MonthlyTarget $monthlyTarget)
    {
        $monthlyTarget->delete();

        return redirect()->route('admin.monthly-targets.index')
            ->with('success', 'Monthly target deleted successfully.');
    }
}