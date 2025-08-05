<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

        $event = Event::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'type' => $request->type,
            'order' => $request->order ?? 0,
        ]);

        $event->addMediaFromRequest('featured_image')
            ->toMediaCollection('featured_image');

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $event->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
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

        $event->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'type' => $request->type,
            'order' => $request->order ?? $event->order,
        ]);

        if ($request->hasFile('featured_image')) {
            $event->clearMediaCollection('featured_image');
            $event->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $event->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function deleteImage(Event $event, $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        if ($media->model_id == $event->id) {
            $media->delete();
            return back()->with('success', 'Image deleted successfully.');
        }
        return back()->with('error', 'Failed to delete image.');
    }
}