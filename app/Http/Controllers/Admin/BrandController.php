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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('brands', 'public');
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
        'name' => 'required|unique:brands,name,' . $brand->id,
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'remove_image' => 'nullable|boolean',
    ]);

    $data = [
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
    ];

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        $data['image'] = $request->file('image')->store('brands', 'public');
    }

    // Handle image removal
    if ($request->has('remove_image') && $brand->image) {
        Storage::disk('public')->delete($brand->image);
        $data['image'] = null;
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