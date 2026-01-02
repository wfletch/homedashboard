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
        @foreach ($completedTasks as $task)
                <tr>
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
