<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Project ID</th>
            <th>Week</th>
            <th>Duration</th>
            <th>Notes</th>
            <th>Tags</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($completedTasks as $completedTask)
            <tr>
                <td>{{ $completedTask->project->name}}</td>
                <td>{{ $completedTask->iso_week}}</td>
                <td>{{ $completedTask->duration_human}}</td>
                <td>{{ $completedTask->notes ?? '—' }}</td>
                <td>{{ $completedTask->tags ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
