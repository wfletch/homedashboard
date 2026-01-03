<!DOCTYPE html>
<html>
<head>
    <title>Life</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="{{ asset('js/vendor/htmx.js') }}"></script>
</head>
<body>

<h1>Warren's Time 2026</h1>

<button id="openBacklogEntryModalBtn">Add Backlog Entry</button>
<button id="openStartTaskModalBtn" {{ !$runningTask ? '' : 'disabled' }}>Start Task</button>


<form method="POST" action="/tasks/end-task">
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


<div
    id="editCounterModal"
    class="modal"
    hx-on:htmx:afterSwap="
        console.log('Target content swapped');
        this.classList.remove('hidden');
    "
></div>
<div
    id="editCompletedTaskModal"
    class="modal"
    hx-on:htmx:afterSwap="
        console.log('Target content swapped');
        this.classList.remove('hidden');
    "
></div>

@if ($counters->isEmpty())
    <p>No Counters.</p>
@else
    <div
        id="counters-table-container"
        hx-get="/counters"
        hx-trigger="load, every 5s"
        hx-swap="innerHTML"
    >
        @include('tasks._current_task', ['runningTask' => $runningTask])
    </div>
@endif
@if ($completedTasks->isEmpty())
    <p>No Completed Tasks.</p>
@else
    <div
        id="current-task"
        hx-get="/tasks/current-task"
        hx-trigger="load, every 5s"
        hx-swap="innerHTML"
    >
        @include('counters._table', ['counters' => $counters])
    </div>

    <div
        id="completed-task"
        hx-get="/completed-tasks"
        hx-trigger="load, every 15s"
        hx-swap="innerHTML"
    >
        @include('tasks._completed_task', ['completedTasks' => $completedTasks])
    </div>
@endif

<div id="startTaskModal" class="modal">
    <div class="modal-content">
        <span id="closeStartTaskModalBtn" class="close">&times;</span>

        <h2>Start Task</h2>

        <form method="POST" action="/tasks/start-task">
            @csrf

            <label>
                Project
                <select name="project_id" required>
                    <option value="" disabled selected>
                        Select a project
                    </option>

                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            @selected(old('project_id') == $project->id)>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
            Title
                <input
                    type="text"
                    name="title"
                    maxlength="255"
                    placeholder="Optional title"
                >
            </label>
            <label>
                Notes
                <textarea name="notes" rows="4">{{ old('notes') }}</textarea>
            </label>

            <button type="submit">Start</button>
        </form>
    </div>
</div>
<div id="addBacklogEntryModal" class="modal">
    <div class="modal-content">
        <span id="closeBacklogEntryModalBtn" class="close">&times;</span>

        <h2>Add Backlogged Entry</h2>

        <form method="POST" action="/completed-tasks/add-completed-task">
            @csrf

            <label>
                Project
                <select name="project_id" required>
                    <option value="" disabled selected>
                        Select a project
                    </option>

                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                Title
                <input
                    type="text"
                    name="title"
                    maxlength="255"
                    placeholder="Optional title"
                >
            </label>
            <label>
                Duration (hours)
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

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
