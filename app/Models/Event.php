<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected $appends = [
        'featured_image_url',
        'gallery_images'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        // Single featured image
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->useFallbackUrl('/images/default-event.jpg')
            ->useFallbackPath(public_path('/images/default-event.jpg'));

        // Multiple gallery images
        $this->addMediaCollection('gallery');
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('featured_image');
    }

    public function getGalleryImagesAttribute()
    {
        return $this->getMedia('gallery');
    }
}