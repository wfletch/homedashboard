<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use App\Models\CounterEntry;

class CounterEntryController extends Controller
{
    public function addCounterEntry(Request $request, Counter $counter)
    {
        $entry = $counter->entries()->create();

        return redirect('/');
    }

    public function removeCounterEntry(Counter $counter, CounterEntry $counterEntry) {
        abort_unless(
            $counterEntry->counter_id === $counter->id,
            404
        );

        $counterEntry->delete();

        return redirect('/');
    }
}
