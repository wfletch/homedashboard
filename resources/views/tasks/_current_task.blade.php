@if ($runningTask)

    <table class="table table-bordered w-full">
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Week</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Notes</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            <tr class="row-current">
                <td>{{ $runningTask->project->name}}</td>
                <td>{{ $runningTask->iso_week}}_D{{$runningTask->day_of_year}}</td>
                <td>{{ $runningTask->title}}</td>
                <td>{{ $runningTask->current_duration_human }}</td>
                <td>{{ $runningTask->notes ?? '—' }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endif
