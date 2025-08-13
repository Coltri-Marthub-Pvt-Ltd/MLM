<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;


class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query()
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->order == 'oldest', function($query) {
                $query->oldest();
            })
            ->when($request->order == 'order_asc', function($query) {
                $query->orderBy('order');
            })
            ->when($request->order == 'order_desc', function($query) {
                $query->orderByDesc('order');
            })
            ->latest()
            ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:events,slug',
        'description' => 'nullable|string',
        'type' => 'required|in:upcoming,current',
        'order' => 'nullable|integer',
        'featured_image' => 'required|image|max:2048',
        'gallery.*' => 'nullable|image|max:2048',
    ]);

    // Create directories if they don't exist
    $featuredDir = public_path('uploads/events/featured');
    $galleryDir = public_path('uploads/events/gallery');
    File::ensureDirectoryExists($featuredDir);
    File::ensureDirectoryExists($galleryDir);

    // Store featured image
    $featuredImageName = time().'_'.$request->file('featured_image')->getClientOriginalName();
    $request->file('featured_image')->move($featuredDir, $featuredImageName);
    $featuredImagePath = 'uploads/events/featured/'.$featuredImageName;

    // Create event
    $event = Event::create([
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
        'type' => $request->type,
        'order' => $request->order ?? 0,
        'featured_image' => $featuredImagePath,
        'date'=>$request->date,
    ]);

    // Store gallery images
    if ($request->hasFile('gallery')) {
        $galleryPaths = [];
        foreach ($request->file('gallery') as $image) {
            $galleryImageName = time().'_'.$image->getClientOriginalName();
            $image->move($galleryDir, $galleryImageName);
            $galleryPaths[] = 'uploads/events/gallery/'.$galleryImageName;
        }
        $event->gallery = $galleryPaths;
        $event->save();
    }

    return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
}

public function update(Request $request, Event $event)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => [
            'required',
            'string',
            'max:255',
            Rule::unique('events')->ignore($event->id),
        ],
        'description' => 'nullable|string',
        'type' => 'required|in:upcoming,current',
        'order' => 'nullable|integer',
        'featured_image' => 'nullable|image|max:2048',
        'gallery.*' => 'nullable|image|max:2048',
    ]);

    $data = [
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
        'type' => $request->type,
        'date'=>$request->date,
        'order' => $request->order ?? $event->order,
    ];

    // Update featured image if provided
    if ($request->hasFile('featured_image')) {
        // Delete old image
        if ($event->featured_image && file_exists(public_path($event->featured_image))) {
            unlink(public_path($event->featured_image));
        }

        $featuredDir = public_path('uploads/events/featured');
        File::ensureDirectoryExists($featuredDir);

        $featuredImageName = time().'_'.$request->file('featured_image')->getClientOriginalName();
        $request->file('featured_image')->move($featuredDir, $featuredImageName);
        $data['featured_image'] = 'uploads/events/featured/'.$featuredImageName;
    }

    // Update gallery images if provided
    if ($request->hasFile('gallery')) {
        // Delete old gallery images
        if ($event->gallery) {
            foreach ($event->gallery as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        $galleryDir = public_path('uploads/events/gallery');
        File::ensureDirectoryExists($galleryDir);

        $galleryPaths = [];
        foreach ($request->file('gallery') as $image) {
            $galleryImageName = time().'_'.$image->getClientOriginalName();
            $image->move($galleryDir, $galleryImageName);
            $galleryPaths[] = 'uploads/events/gallery/'.$galleryImageName;
        }
        $data['gallery'] = $galleryPaths;
    }

    $event->update($data);

    return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
}

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }



public function destroy(Event $event)
{
    // Delete featured image
    if ($event->featured_image && file_exists(public_path($event->featured_image))) {
        unlink(public_path($event->featured_image));
    }

    // Delete gallery images
    if ($event->gallery) {
        foreach ($event->gallery as $image) {
            if (file_exists(public_path($image))) {
                unlink(public_path($image));
            }
        }
    }

    $event->delete();
    return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
}

    public function deleteImage(Event $event, $imageIndex)
    {
        if (isset($event->gallery[$imageIndex])) {
            Storage::disk('public')->delete($event->gallery[$imageIndex]);

            $gallery = $event->gallery;
            unset($gallery[$imageIndex]);
            $event->gallery = array_values($gallery); // Reindex array
            $event->save();

            return back()->with('success', 'Image deleted successfully.');
        }

        return back()->with('error', 'Failed to delete image.');
    }
}
