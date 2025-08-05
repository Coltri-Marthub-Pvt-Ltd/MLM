<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the parent category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all products in this category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all descendant categories
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Check if this category has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Get the breadcrumb path
     */
    public function getBreadcrumbAttribute(): array
    {
        $breadcrumb = [];
        $category = $this;
        
        while ($category) {
            array_unshift($breadcrumb, $category);
            $category = $category->parent;
        }
        
        return $breadcrumb;
    }

    /**
     * Scope for root categories (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for categories with children
     */
    public function scopeWithChildren($query)
    {
        return $query->has('children');
    }
}
