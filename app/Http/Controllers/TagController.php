<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * List all tags (optionally grouped by category)
     */
    public function index()
    {
        return Tag::orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy(fn ($tag) => $tag->category ?? 'uncategorized');
    }

    /**
     * Create a new tag
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:50',
            'category' => 'nullable|string|max:50',
            'enabled'  => 'boolean',
        ]);

        // Prevent duplicate (name + category)
        $tag = Tag::firstOrCreate(
            [
                'name'     => $validated['name'],
                'category' => $validated['category'] ?? null,
            ],
            [
                'enabled' => $validated['enabled'] ?? true,
            ]
        );

        return response()->json($tag, 201);
    }

    /**
     * Toggle enabled/disabled state
     */
    public function toggle(Tag $tag)
    {
        $tag->update([
            'enabled' => ! $tag->enabled,
        ]);

        return response()->json($tag);
    }

    /**
     * Delete a tag (hard delete)
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->noContent();
    }
}
