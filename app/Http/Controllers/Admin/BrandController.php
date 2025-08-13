<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:brands,name',
        'description' => 'nullable|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = [
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
    ];

    // Handle image upload to public folder
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time().'_'.Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        
        // Store in public/images/brands
        $image->move(public_path('images/brands'), $filename);
        
        // Save path relative to public folder
        $data['image'] = 'images/brands/'.$filename;
    }

    Brand::create($data);

    return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
}

 // In your show method
public function show($id)
{
    $brand = Brand::with('products')->findOrFail($id);
    return view('admin.brands.show', compact('brand'));
}

// In your edit method
public function edit($id)
{
    $brand = Brand::findOrFail($id);
    return view('admin.brands.edit', compact('brand'));
}

public function update(Request $request, Brand $brand)
{
    $request->validate([
        'name' => 'required|unique:brands,name,'.$brand->id,
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'remove_image' => 'nullable|boolean',
    ]);

    $data = [
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
    ];

    // Handle image removal
    if ($request->remove_image && $brand->image) {
        $oldImagePath = public_path($brand->image);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $data['image'] = null;
    }

    // Handle new image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($brand->image) {
            $oldImagePath = public_path($brand->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        // Store new image
        $image = $request->file('image');
        $filename = time().'_'.Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images/brands'), $filename);
        $data['image'] = 'images/brands/'.$filename;
    }

    $brand->update($data);

    return response()->json(['success' => true, 'message' => 'Brand updated successfully']);
}

    public function destroy(Brand $brand)
    {
        // Delete image if exists
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}