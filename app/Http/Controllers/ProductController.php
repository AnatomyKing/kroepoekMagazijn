<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Alle items ophalen (voor de tegelweergave)
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return response()->json($items);
    }

    // Nieuw product opslaan (heb je al)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity_available' => 'required|integer|min:0',
            'status' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validated['image'] = $path;
        }

        $validated['quantity_total'] = $validated['quantity_available'];
        $validated['status'] = $request->input('status', 'available');

        $item = Item::create($validated);

        return response()->json(['success' => true, 'item' => $item], 201);
    }

    // Product bijwerken (edit/update)
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity_available' => 'required|integer|min:0',
            'status' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Verwijder oude afbeelding als die bestaat
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('items', 'public');
            $validated['image'] = $path;
        }

        $validated['quantity_total'] = $validated['quantity_available'];
        $validated['status'] = $request->input('status', 'available');

        $item->update($validated);

        return response()->json(['success' => true, 'item' => $item]);
    }

    // Product verwijderen
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        // Verwijder afbeelding als die bestaat
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();

        return response()->json(['success' => true]);
    }
}
