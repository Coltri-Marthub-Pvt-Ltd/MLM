<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->orderBy('name')
            ->paginate(15);
            
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();
            
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $data = $request->all();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);
        $stats = [
            'products_count' => $category->products()->count(),
            'children_count' => $category->children()->count(),
            'total_descendants' => $this->getTotalDescendants($category)
        ];
        
        return view('admin.categories.show', compact('category', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
            
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        // Prevent category from being its own parent or child
        if ($request->parent_id == $category->id) {
            return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        // Prevent circular references
        if ($request->parent_id && $this->wouldCreateCircularReference($category, $request->parent_id)) {
            return back()->withErrors(['parent_id' => 'This would create a circular reference.']);
        }

        $data = $request->all();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->exists()) {
            return back()->withErrors(['delete' => 'Cannot delete category with products. Please move or delete products first.']);
        }

        // Check if category has children
        if ($category->children()->exists()) {
            return back()->withErrors(['delete' => 'Cannot delete category with subcategories. Please delete subcategories first.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Get total number of descendant categories
     */
    private function getTotalDescendants(Category $category): int
    {
        $count = 0;
        foreach ($category->children as $child) {
            $count++;
            $count += $this->getTotalDescendants($child);
        }
        return $count;
    }

    /**
     * Check if setting a parent would create a circular reference
     */
    private function wouldCreateCircularReference(Category $category, int $parentId): bool
    {
        $descendants = $this->getAllDescendantIds($category);
        return in_array($parentId, $descendants);
    }

    /**
     * Get all descendant IDs of a category
     */
    private function getAllDescendantIds(Category $category): array
    {
        $ids = [];
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getAllDescendantIds($child));
        }
        return $ids;
    }
}
