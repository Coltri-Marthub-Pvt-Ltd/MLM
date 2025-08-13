<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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

    $data = [
        'name' => $request->name,
        'coins' => $request->coins,
    ];

    // Handle image upload to public folder
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time().'_'.Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        
        // Create directory if it doesn't exist
        if (!File::exists(public_path('images/badges'))) {
            File::makeDirectory(public_path('images/badges'), 0755, true);
        }
        
        // Store in public/images/badges
        $image->move(public_path('images/badges'), $filename);
        
        // Save path relative to public folder
        $data['image'] = 'images/badges/'.$filename;
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

    $data = [
        'name' => $request->name,
        'coins' => $request->coins,
    ];

    // Handle image removal
    if ($request->remove_image) {
        if ($badge->image && File::exists(public_path($badge->image))) {
            File::delete(public_path($badge->image));
            $data['image'] = null;
        }
    }

    // Handle new image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($badge->image && File::exists(public_path($badge->image))) {
            File::delete(public_path($badge->image));
        }

        $image = $request->file('image');
        $filename = time().'_'.Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        
        // Create directory if it doesn't exist
        if (!File::exists(public_path('images/badges'))) {
            File::makeDirectory(public_path('images/badges'), 0755, true);
        }
        
        // Store in public/images/badges
        $image->move(public_path('images/badges'), $filename);
        
        // Save path relative to public folder
        $data['image'] = 'images/badges/'.$filename;
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
