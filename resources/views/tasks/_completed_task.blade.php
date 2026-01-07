@foreach ($completedTasksByWeek as $isoWeek => $tasks)
<div class="my-12">
    <!-- Week header (clickable) -->


<button
    type="button"
    class="w-full text-center focus:outline-none"
    @click="open = !open"
>
    <div class="text-2xl font-bold">
        {{ str_replace('-W', ' – Week ', $isoWeek) }}
    </div>

    <div
        class="mt-3 h-1 w-32 mx-auto rounded-full bg-pink-300
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
                    <th>Project</th>
                    <th>Year / Week / Day</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Notes</th>
                    <th>Tags</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $currentDay   = null;
                    $dailySeconds = 0;
                    $dailyCount   = 0;
                    $dayClass     = null;
                @endphp

                @foreach ($tasks as $task)

                    {{-- 🔹 DAY CHANGE → SUMMARY ROW --}}
                    @if ($currentDay !== null && $task->day_of_year !== $currentDay)
                        <tr class="{{ $dayClass }}-summary row-summary">
                            <td colspan="3" class="text-right">
                                Daily total
                            </td>
                            <td>
                                {{ \Carbon\CarbonInterval::seconds($dailySeconds)
                                    ->cascade()
                                    ->forHumans([
                                        'short' => true,
                                        'minimumUnit' => 'minute',
                                    ]) }}
                            </td>
                            <td colspan="3">
                                {{ $dailyCount }} task{{ $dailyCount !== 1 ? 's' : '' }}
                            </td>
                        </tr>

                        @php
                            $dailySeconds = 0;
                            $dailyCount   = 0;
                        @endphp
                    @endif

                    {{-- 🔹 SET DAY + CLASS --}}
                    @php
                        $currentDay = $task->day_of_year;

                        $dayClass = match ($task->day_of_year % 7) {
                            1 => 'row-monday',
                            2 => 'row-tuesday',
                            3 => 'row-wednesday',
                            4 => 'row-thursday',
                            5 => 'row-friday',
                            6,7 => 'row-weekend',
                            default => 'row-weekend',
                        };

                        $dailySeconds += (int) round($task->duration * 3600);
                        $dailyCount++;
                    @endphp

                    {{-- 🔹 NORMAL TASK ROW --}}
                    <tr class="{{ $dayClass }}">
                        <td>{{ $task->project->name }}</td>
                        <td>{{ $task->iso_week }}_D{{ $task->day_of_week }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->duration_human }}</td>
                        <td>{{ $task->notes ?? '—' }}</td>
                        <td>{{ $task->tags ?? '—' }}</td>
                        <td>
                            <button
                                class="btn btn-outline"
                                hx-get="/completed-tasks/{{ $task->id }}/edit"
                                hx-target="#editCompletedTaskModalContent"
                            >
                                ✏️
                            </button>
                        </td>
                    </tr>
                @endforeach

                {{-- 🔹 FINAL DAY SUMMARY --}}
                @if ($currentDay !== null)
                    <tr class="{{ $dayClass }}-summary row-summary">
                        <td colspan="3" class="text-right">
                            Daily total
                        </td>
                        <td>
                            {{ \Carbon\CarbonInterval::seconds($dailySeconds)
                                ->cascade()
                                ->forHumans([
                                    'short' => true,
                                    'minimumUnit' => 'minute',
                                ]) }}
                        </td>
                        <td colspan="3">
                            {{ $dailyCount }} task{{ $dailyCount !== 1 ? 's' : '' }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endforeach
