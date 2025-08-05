<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'points',
        'image',
        'category_id',
        'location_id',
        'brand_id',
        'product_type_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'points' => 'integer'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
        
        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Relationship with Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship with Brand
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Relationship with Location
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Relationship with ProductType
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Relationship with Cart
     */
    public function cart()
    {
        return $this->hasOne(Cart::class)->where('user_id', Auth::guard('contractor')->user()->id);
    }

    /**
     * Get the formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->price, 2);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            return asset('storage/'.$this->image);
        }
        
        return asset('images/placeholder-product.jpg');
    }

    /**
     * Get short description
     */
    public function getShortDescriptionAttribute(): string
    {
        if ($this->description) {
            return Str::limit(strip_tags($this->description), 100);
        }
        return 'No description available.';
    }

    /**
     * Scope for products in a specific category
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope for products with price range
     */
    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
    }
}