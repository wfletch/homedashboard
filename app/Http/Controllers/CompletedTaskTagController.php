<?php

namespace App\Http\Controllers;

use App\Models\CompletedTask;
use Illuminate\Http\Request;
use App\Models\Tag;

class CompletedTaskTagController extends Controller
{
    /**
     * Attach one or more tags to a completed task
     */
    public function attach(Request $request, CompletedTask $completedTask)
    {
        $validated = $request->validate([
            'tag_ids'   => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $validatedIds = Tag::whereIn('id', $validated['tag_ids'])
            ->where('enabled', true)
            ->pluck('id');

        $completedTask->tags()->syncWithoutDetaching($validatedIds);

        return response()->json([
            'message' => 'Tags attached successfully',
            'tags'    => $completedTask->load('tags')->tags,
        ]);
    }

    /**
     * Sync tags (replace all existing tags)
     */
    public function sync(Request $request, CompletedTask $completedTask)
    {
        $validated = $request->validate([
            'tag_ids'   => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $completedTask
            ->tags()
            ->sync($validated['tag_ids']);

        return response()->json([
            'message' => 'Tags synced successfully',
            'tags'    => $completedTask->load('tags')->tags,
        ]);
    }

    /**
     * Detach a single tag
     */
    public function detach(CompletedTask $completedTask, int $tagId)
    {
        $completedTask
            ->tags()
            ->detach($tagId);

        return response()->json([
            'message' => 'Tag detached successfully',
        ]);
    }
}
