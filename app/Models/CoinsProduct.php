<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\CoinsOders;


class CoinsProduct extends Model
{
    protected $table = 'cons_products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'points',
        'image',
        'category_id'
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
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
        public function order()
    {
        return $this->hasMany(CoinsOders::class,'product_id','id');
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
