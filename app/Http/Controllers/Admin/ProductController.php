<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Location;
use App\Models\Brand;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->inCategory($request->category);
        }

        // Price range filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        $products = $query->orderBy('id', 'desc')->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'locations', 'brands', 'productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'points' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'brand_id' => 'nullable|exists:brands,id',
            'product_type_id' => 'nullable|exists:product_types,id'
        ]);

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Set default values for nullable fields
        $data['points'] = $data['points'] ?? 0;
        $data['category_id'] = $data['category_id'] ?? null;
        $data['location_id'] = $data['location_id'] ?? null;
        $data['brand_id'] = $data['brand_id'] ?? null;
        $data['product_type_id'] = $data['product_type_id'] ?? null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'points' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'brand_id' => 'nullable|exists:brands,id',
            'product_type_id' => 'nullable|exists:product_types,id'
        ]);

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Set default values for nullable fields
        $data['points'] = $data['points'] ?? 0;
        $data['category_id'] = $data['category_id'] ?? null;
        $data['location_id'] = $data['location_id'] ?? null;
        $data['brand_id'] = $data['brand_id'] ?? null;
        $data['product_type_id'] = $data['product_type_id'] ?? null;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'location', 'productType']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'locations', 'brands', 'productTypes'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Remove product image
     */
    public function removeImage(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->update(['image' => null]);

        return back()->with('success', 'Product image removed successfully.');
    }
}
