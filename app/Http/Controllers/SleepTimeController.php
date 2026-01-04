<?php

namespace App\Http\Controllers;
use App\Models\SleepTime;
use Illuminate\Http\Request;

class SleepTimeController extends Controller
{
    public function getAllSleepTimesGroupedByWeek()
    {
        $sleepTimes = SleepTime::orderBy('day')->get();

        $sleepTimesByWeek = $sleepTimes->groupBy(function ($sleep) {
            return $sleep->day->format('o-\WW');
        });

        return view('sleep_times._sleep_times_table', compact('sleepTimesByWeek'));
    }

    public function createNewSleepTimeView()
    {
        return view('sleep_times._add_sleep_times_entry');
    }

    public function createNewSleepTime(Request $request)
    {
        $data = $request->validate([
            'day' => ['required', 'date', 'unique:sleep_times,day'],
            'bed_time' => ['required'],
            'wake_time' => ['required'],
        ]);

        SleepTime::create($data);


        return response()->noContent();
    }

    public function editSleepTimeView(SleepTime $sleepTime)
    {
        return view('sleep_times._edit_sleep_times_entry', compact('sleepTime'));
    }

    public function editSleepTime(Request $request, SleepTime $sleepTime)
    {
        $data = $request->validate([
            'day' => ['required', 'date', 'unique:sleep_times,day,' . $sleepTime->id],
            'bed_time' => ['required'],
            'wake_time' => ['required'],
        ]);

        $sleepTime->update($data);


        return view('sleep_times._edit_sleep_times_entry', compact('sleepTime'));
    }

    public function removeSleepTimeEntry(SleepTime $sleepTime)
    {

        $sleepTime->delete();
        return redirect('/');

    }
}
