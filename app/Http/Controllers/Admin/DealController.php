<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::orderBy('order', 'asc')->get();
        return view('admin.deals.index', compact('deals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:deals,name',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('deals', 'public');
        }

        Deal::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Deal created successfully'
        ]);
    }

    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:deals,name,'.$deal->id,
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'remove_image']);

        // Handle image removal
        if ($request->remove_image) {
            if ($deal->image) {
                Storage::disk('public')->delete($deal->image);
                $data['image'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($deal->image) {
                Storage::disk('public')->delete($deal->image);
            }
            $data['image'] = $request->file('image')->store('deals', 'public');
        }

        $deal->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Deal updated successfully'
        ]);
    }

    public function destroy(Deal $deal)
    {
        if ($deal->image) {
            Storage::disk('public')->delete($deal->image);
        }

        $deal->delete();
                return redirect()->route('admin.deals.index')->with('success', 'Deals deleted successfully.');

    }
}