<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();

        return response()->json(
            $items->map(fn (Item $item) => $this->formatItem($item))->values()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity_available' => 'required|integer|min:0',
            'status' => 'nullable|in:available,unavailable',
            'video_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:4096',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $validated['type'] = $validated['type'] ?? $validated['category'];
        $validated['images'] = $validated['images'] ?? [];
        $validated['quantity_total'] = $validated['quantity_available'];
        $validated['status'] = $validated['status']
            ?? ($validated['quantity_available'] > 0 ? 'available' : 'unavailable');

        $item = Item::create($validated);

        return response()->json([
            'success' => true,
            'item' => $this->formatItem($item->fresh()),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity_available' => 'required|integer|min:0',
            'status' => 'nullable|in:available,unavailable',
            'video_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:4096',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($item->image);

            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $validated['type'] = $validated['type'] ?? $validated['category'];
        $validated['quantity_total'] = $validated['quantity_available'];
        $validated['status'] = $validated['status']
            ?? ($validated['quantity_available'] > 0 ? 'available' : 'unavailable');

        $item->update($validated);

        return response()->json([
            'success' => true,
            'item' => $this->formatItem($item->fresh()),
        ]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $this->deleteStoredImage($item->image);

        $item->delete();

        return response()->json(['success' => true]);
    }

    private function formatItem(Item $item): array
    {
        $extraImages = collect($item->images ?? [])
            ->filter()
            ->values();

        return [
            'id' => $item->id,

            'item_name' => $item->item_name,
            'type' => $item->type ?: ($item->category ?: 'Overig'),
            'description' => $item->description,
            'category' => $item->category ?: 'Overig',

            'image' => $item->image,
            'image_url' => $this->mediaUrl($item->image),

            'images' => $extraImages->all(),
            'images_urls' => $extraImages
                ->map(fn ($image) => $this->mediaUrl($image))
                ->filter()
                ->values()
                ->all(),

            'quantity_total' => $item->quantity_total,
            'quantity_available' => $item->quantity_available,
            'status' => $item->status,

            'video_link' => $item->video_link,

            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    private function mediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/storage/')) {
            return $path;
        }

        if (str_starts_with($path, '/images/')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return '/' . $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function deleteStoredImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        // Only delete uploaded storage files, not seeded public/images demo files.
        if (str_starts_with($path, 'items/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
