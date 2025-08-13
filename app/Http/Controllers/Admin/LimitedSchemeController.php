<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LimitedScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LimitedSchemeController extends Controller
{
    public function index()
    {
        $limitedSchemes = LimitedScheme::orderBy('order', 'asc')->get();
        return view('admin.limited-schemes.index', compact('limitedSchemes'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:limited_schemes,name',
        'description' => 'nullable|string',
        'coins' => 'required|integer|min:0',
        'order' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->except('image');

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('images/limited-schemes'), $imageName);
        $data['image'] = 'images/limited-schemes/'.$imageName;
    }

    LimitedScheme::create($data);

    return response()->json([
        'success' => true,
        'message' => 'Limited Scheme created successfully'
    ]);
}

public function update(Request $request, LimitedScheme $limitedScheme)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:limited_schemes,name,'.$limitedScheme->id,
        'description' => 'nullable|string',
        'coins' => 'required|integer|min:0',
        'order' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'remove_image' => 'nullable|boolean',
    ]);

    $data = $request->except(['image', 'remove_image']);

    // Handle image removal
    if ($request->remove_image) {
        if ($limitedScheme->image) {
            $oldImagePath = public_path($limitedScheme->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $data['image'] = null;
        }
    }

    // Handle new image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($limitedScheme->image) {
            $oldImagePath = public_path($limitedScheme->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('images/limited-schemes'), $imageName);
        $data['image'] = 'images/limited-schemes/'.$imageName;
    }

    $limitedScheme->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Limited Scheme updated successfully'
    ]);
}

    public function destroy(LimitedScheme $limitedScheme)
    {
        if ($limitedScheme->image) {
            Storage::disk('public')->delete($limitedScheme->image);
        }

        $limitedScheme->delete();

              return redirect()->route('admin.limited-schemes.index')->with('success', 'limited Scheme deleted successfully.');

    }
}