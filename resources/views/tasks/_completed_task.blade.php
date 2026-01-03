@foreach ($completedTasksByWeek as $isoWeek => $tasks)
<div x-data="{ open: true }" class="my-12">

    <!-- Week header (clickable) -->
    <button
        type="button"
        class="w-full text-center focus:outline-none"
        @click="open = !open"
    >
        <div class="text-2xl font-bold">
            {{ str_replace('-W', ' – Week ', $isoWeek) }}
        </div>

        <!-- south accent -->
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
                    <th>Project ID</th>
                    <th>Year/Week/Day</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Notes</th>
                    <th>Tags</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    @php
                        $dayClass = match ($task->day_of_year % 7) {
                            1 => 'row-monday',
                            2 => 'row-tuesday',
                            3 => 'row-wednesday',
                            4 => 'row-thursday',
                            5 => 'row-friday',
                            6,7 => 'row-weekend',
                            default => 'row-weekend',
                        };
                    @endphp

                    <tr class="{{ $dayClass }}">
                        <td>{{ $task->project->name }}</td>
                        <td>{{ $task->iso_week }}_D{{ $task->day_of_year }}</td>
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
            </tbody>
        </table>
    </div>

</div>
@endforeach
