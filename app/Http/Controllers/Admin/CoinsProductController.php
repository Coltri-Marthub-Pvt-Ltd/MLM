<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoinsProduct;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CoinsProductController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = CoinsProduct::with('category');

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

        $products = $query->orderBy('id','desc')->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('admin.coins_products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coins_products.create');
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
        'points' => 'nullable|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'nullable|exists:categories,id'
    ]);

    $data = $request->all();

    // Generate slug if not provided
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['name']);
    }

    // Handle image upload to public/products
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('products');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $image->move($destinationPath, $filename);
        $data['image'] = 'products/' . $filename;
    }

    CoinsProduct::create($data);

    return redirect()->route('admin.coins-products.index')
        ->with('success', 'Coins Product created successfully.');
}

public function update(Request $request, CoinsProduct $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
        'description' => 'nullable|string',
        'points' => 'nullable|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'nullable|exists:categories,id'
    ]);

    $data = $request->all();

    // Generate slug if not provided
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['name']);
    }

    // Handle image upload to public/products
    if ($request->hasFile('image')) {
        // Delete old image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $image = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('products');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $image->move($destinationPath, $filename);
        $data['image'] = 'products/' . $filename;
    }

    $product->update($data);

    return redirect()->route('admin.coins-products.show', $product)
        ->with('success', 'Coins Product updated successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(CoinsProduct $product)
    {
        $product->load('category');
        return view('admin.coins_products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoinsProduct $product)
    {
        return view('admin.coins_products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoinsProduct $product)
    {
        // Delete associated image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.coins-products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Remove product image
     */
    public function removeImage(CoinsProduct $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->update(['image' => null]);

        return back()->with('success', 'Product image removed successfully.');
    }
}
