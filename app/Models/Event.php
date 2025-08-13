<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'order',
        'featured_image',
        'gallery',
        'date'
    ];

    protected $casts = [
        'order' => 'integer',
        'gallery' => 'array',
        'date' => 'date'
    ];

    protected $appends = [
        'featured_image_url',
        'gallery_urls'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset($this->featured_image) : asset('images/default-event.jpg');
    }

    public function getGalleryUrlsAttribute()
    {
        if (empty($this->gallery)) {
            return [];
        }

        return array_map(function($path) {
            return asset($path);
        }, $this->gallery);
    }
}
