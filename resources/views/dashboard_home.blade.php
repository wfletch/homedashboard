<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<h1>Dashboard</h1>

<button id="openBacklogEntryModalBtn">Add Backlog Entry</button>
<button id="openStartTaskModalBtn">Start Task</button>


<form method="POST" action="/dashboard/end-task">
    @csrf
    <button type="submit" {{ $runningTask ? '' : 'disabled' }}>
        End Task
    </button>
</form>

@if ($errors->any())
    <div style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($durations->isEmpty())
    <p>No project durations found.</p>
@else
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project ID</th>
                <th>Week</th>
                <th>Duration</th>
                <th>Notes</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($durations as $duration)
                <tr>
                    <td>{{ $duration->id }}</td>
                    <td>{{ $duration->project_id }}</td>
                    <td>{{ $duration->iso_week}}</td>
                    <td>{{ $duration->duration }}</td>
                    <td>{{ $duration->notes ?? '—' }}</td>
                    <td>{{ $duration->tags ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>

<div id="startTaskModal" class="modal">
    @csrf
    <div class="modal-content">
        <span id="closeStartTaskModalBtn" class="close">&times;</span>

        <h2>Start Task</h2>
        <form method="POST" action="/dashboard/start-task">
            @csrf

            <label>
                Project ID
                <input type="number" name="project_id" required>
            </label>

            <label>
                Notes
                <textarea name="notes" rows="4"></textarea>
            </label>
            <button type="submit">Start</button>
        </form>
    </div>
</div>
<div id="addBacklogEntryModal" class="modal">
    @csrf
    <div class="modal-content">
        <span id="closeBacklogEntryModalBtn" class="close">&times;</span>

        <h2>Add Backlogged Entry</h2>
        <form method="POST" action="/dashboard/project-duration">
            @csrf

            <label>
                Project ID
                <input type="number" name="project_id" required>
            </label>

            <label>
                Duration
                <input type="number" step="0.25" name="duration" required>
            </label>

            <label>
                Notes
                <textarea name="notes" rows="4"></textarea>
            </label>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
</html>
