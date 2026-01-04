@foreach ($sleepTimesByWeek as $isoWeek => $sleeps)
<div x-data="{ open: true }" class="my-12">

    <!-- Week header -->
    <button
        type="button"
        class="w-full text-center focus:outline-none"
        @click="open = !open"
    >
        <div class="text-2xl font-bold">
            {{ str_replace('-W', ' – Week ', $isoWeek) }}
        </div>

        <div
            class="mt-3 h-1 w-32 mx-auto rounded-full bg-indigo-300
                   transition-all duration-300"
            :class="open ? 'opacity-100' : 'opacity-40 w-20'"
        ></div>
    </button>

    <!-- Collapsible content -->
    <div
        x-show="open"
        x-transition
        x-cloak
        class="mt-6"
    >
        <table class="table table-bordered w-full">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Bed</th>
                    <th>Wake</th>
                    <th>Sleep Hours</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sleeps as $sleep)
                    @php
                        $dayClass = match ($sleep->day->dayOfWeekIso) {
                            1 => 'row-monday',
                            2 => 'row-tuesday',
                            3 => 'row-wednesday',
                            4 => 'row-thursday',
                            5 => 'row-friday',
                            6,7 => 'row-weekend',
                        };
                    @endphp

                    <tr class="{{ $dayClass }}">
                        <td>{{ $sleep->day->toDateString() }}</td>
                        <td>{{ $sleep->bed_time }}</td>
                        <td>{{ $sleep->wake_time }}</td>
                        <td>{{ $sleep->sleep_hours ?? '—' }}</td>
                        <td>
                            <button
                                class="btn btn-outline"
                                hx-get="/sleep-times/{{ $sleep->id }}/edit"
                                hx-target="#editSleepTimesModalContent"
                            >
                                ✏️
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
