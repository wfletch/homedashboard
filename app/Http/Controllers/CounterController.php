<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use App\Models\CounterEntry;

class CounterController extends Controller
{

    public function editCounterEntriesView(Counter $counter)
    {
        $counter->load('entries');

        return view('counters._edit_counter', compact('counter'));
    }
    public function getAllCounters()
    {
        $counters = Counter::where('enabled', true)
            ->withCount('entries')
            ->withMax('entries as last_entry_at', 'created_at')
            ->get();
        return view('counters._table', compact('counters'));
    }
    public function getCounter(Counter $counter)
    {
        $counter->load('entries');
        return response()->json([
            'counter' => $counter,
            'entries' => $counter->entries,
            'count'   => $counter->entries->count(),
            'goal'    => $counter->goal,
        ], 200);
    }

    public function addCounterEntry(Counter $counter)
    {
        $counter->entries()->create();


        $counter->load('entries');
        return view('counters._edit_counter', compact('counter'));
    }
    public function removeCounterEntry(CounterEntry $counterEntry)
    {
        $counter = $counterEntry->counter;
        $counterEntry->delete();

        $counter->load('entries');
        return view('counters._edit_counter', compact('counter'));


    }
    public function updateCounterEntry(Request $request, CounterEntry $counterEntry)
    {
        $validated = $request->validate([
            'note' => ['nullable', 'string'],
        ]);

        $counterEntry->update($validated);

        $counter = $counterEntry->counter;
        $counter->load('entries');
        return view('counters._edit_counter', compact('counter'));
    }
}
