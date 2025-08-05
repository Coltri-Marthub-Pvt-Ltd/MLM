<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        return view('admin.badges.index', compact('badges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:badges,name',
            'coins' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('badges', 'public');
        }

        Badge::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Badge created successfully'
        ]);
    }

    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:badges,name,'.$badge->id,
            'coins' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'remove_image']);

        // Handle image removal
        if ($request->remove_image) {
            if ($badge->image) {
                Storage::disk('public')->delete($badge->image);
                $data['image'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($badge->image) {
                Storage::disk('public')->delete($badge->image);
            }
            $data['image'] = $request->file('image')->store('badges', 'public');
        }

        $badge->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Badge updated successfully'
        ]);
    }

    public function destroy(Badge $badge)
    {
        if ($badge->image) {
            Storage::disk('public')->delete($badge->image);
        }
        
        $badge->delete();
        
        return redirect()->route('admin.badges.index')->with('success', 'Badge deleted successfully.');
    }
}
