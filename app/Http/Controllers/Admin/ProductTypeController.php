<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::latest()->get();
        return view('admin.product-types.index', compact('productTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name',
        ]);

        ProductType::create($validated);

        return redirect()->route('admin.product-types.index')
                        ->with('success', 'Product type created successfully.');
    }

    public function update(Request $request, ProductType $productType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name,'.$productType->id,
        ]);

        $productType->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product type updated successfully'
            ]);
        }

        return response()->json([
                'success' => true,
                'message' => 'Product type updated successfully',
                'data' => [
                    'id' => $productType->id,
                    'name' => $productType->name,
                    'created_at' => $productType->created_at->format('M j, Y'),
                ]
            ]);

    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return redirect()->route('admin.product-types.index')
                        ->with('success', 'Product type deleted successfully');
    }
}