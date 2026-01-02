<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function getAllTags()
    {
        return Tag::orderBy('name')->get();
    }

    public function getEnabledTags()
    {
        return Tag::where('enabled', true)->orderBy('name')->get();
    }
    public function updateTag(Request $request, Tag $tag)
    {
        $validated = $request->validate([ 'name'    => ['sometimes', 'string', 'max:255', 'unique:tags,name,' . $tag->id],
            'enabled' => ['sometimes', 'boolean'],
        ]);

        $tag->update($validated);

        return $tag;
    }
}
