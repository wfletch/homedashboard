@foreach ($completedTasksByWeek as $isoWeek => $tasks)
    <h3>Week {{ $isoWeek }}</h3>
    <table border="1" cellpadding="6">
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
                        default => 'row-error',
                    };
                @endphp

                <tr class="{{ $dayClass }}">
                    <td>{{ $task->project->name}}</td>
                    <td>{{ $task->iso_week}}_D{{$task->day_of_year}}</td>
                    <td>{{ $task->title}}</td>
                    <td>{{ $task->duration_human}}</td>
                    <td>{{ $task->notes ?? '—' }}</td>
                    <td>{{ $task->tags ?? '—' }}</td>
                    <td>
                    <button
                        hx-get="/completed-tasks/{{ $task->id }}/edit"
                        hx-target="#editCompletedTaskModal"
                        hx-swap="innerHTML"
                    >
                        ✏️
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
