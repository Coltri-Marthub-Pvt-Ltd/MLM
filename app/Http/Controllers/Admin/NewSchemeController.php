<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewSchemeController extends Controller
{
    public function index()
    {
        $newSchemes = NewScheme::orderBy('order', 'asc')->get();
        return view('admin.new-schemes.index', compact('newSchemes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:new_schemes,name',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('new-schemes', 'public');
        }

        NewScheme::create($data);

        return response()->json([
            'success' => true,
            'message' => 'New Scheme created successfully'
        ]);
    }

    public function update(Request $request, NewScheme $newScheme)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:new_schemes,name,'.$newScheme->id,
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'remove_image']);

        // Handle image removal
        if ($request->remove_image) {
            if ($newScheme->image) {
                Storage::disk('public')->delete($newScheme->image);
                $data['image'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($newScheme->image) {
                Storage::disk('public')->delete($newScheme->image);
            }
            $data['image'] = $request->file('image')->store('new-schemes', 'public');
        }

        $newScheme->update($data);

        return response()->json([
            'success' => true,
            'message' => 'New Scheme updated successfully'
        ]);
    }

    public function destroy(NewScheme $newScheme)
    {
        if ($newScheme->image) {
            Storage::disk('public')->delete($newScheme->image);
        }

        $newScheme->delete();

         return redirect()->route('admin.new-schemes.index')
                         ->with('success', 'new-schemes deleted successfully');
    }
}