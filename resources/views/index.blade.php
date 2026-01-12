@extends('layouts.app')

@section('content')
<header class="flex items-center justify-between gap-4 mt-6 mb-10 px-2 pb-4 border-b border-base-300">
    <h1 class="text-2xl font-bold">
        Warren’s Time 2026
    </h1>

    <div class="flex gap-3 mr-4">

        {{-- Add Backlog Entry (always available) --}}
        <button
            class="btn-primary btn-outline btn-lg"
            onclick="addBacklogEntryModal.showModal()">
            ➕ Add Backlog Entry
        </button>

        {{-- Start / End Task toggle --}}
        @if (!$runningTask)
            {{-- START TASK --}}
            <button
                class="btn-secondary btn-outline btn-lg"
                onclick="startTaskModal.showModal()">
                ▶ Start Task
            </button>
        @else
            {{-- END TASK --}}
            <form
                method="POST"
                action="/tasks/end-task"
                class="nostyle"
                x-data
                @submit.prevent="
                    Swal.fire({
                        title: 'End current task?',
                        text: 'This will stop the timer and log the task.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, end it',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#ef4444',
                        reverseButtons: true,
                        showClass: {
                            popup: 'animate__animated animate__pop'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $el.submit()
                        }
                    })
                "
            >
                @csrf

                <button
                    type="submit"
                    class="btn-secondary btn-outline btn-lg bg-red-700">
                    ⏹ End Task
                </button>
            </form>
        @endif


        <label class="swap swap-rotate text-xl cursor-pointer px-2 py-1 rounded-lg hover:bg-base-200 transition">
            <input
                type="checkbox"
                x-data
                @change="
                    document.documentElement.setAttribute(
                        'data-theme',
                        $event.target.checked ? 'dark' : 'light'
                    )
                "
            />

            <!-- light -->
            <span class="swap-off">🌞</span>

            <!-- dark -->
            <span class="swap-on">🌙</span>
        </label>
    </div>
</header>

@if ($errors->any())
    <div class="toast toast-bottom toast-end z-50">
        @foreach ($errors->all() as $error)
            <div
                class="alert alert-error shadow-lg"
                x-data
                x-init="setTimeout(() => $el.remove(), 5000)"
            >
                <span>❌ {{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif


@if (session('task_ended'))
    <script>
        window.__TASK_ENDED__ = true;
    </script>
@endif
@section('title')
    {{ $runningTask ? $runningTask->current_duration_human : 'Life' }}
@endsection

<dialog id="editSleepTimesModal" class="modal">
    <div class="modal-box modal-lg" id="editSleepTimesModalContent">
        {{-- HTMX content loads here --}}
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>


<dialog id="addNewSleepTimesModal" class="modal">
    <div class="modal-box modal-lg" id="addNewSleepTimesModalContent">
        {{-- HTMX content loads here --}}
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<dialog id="editCounterModal" class="modal">
    <div class="modal-box modal-lg" id="editCounterModalContent">
        {{-- HTMX content loads here --}}
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<dialog id="editCompletedTaskModal" class="modal">
    <div class="modal-box modal-lg" id="editCompletedTaskModalContent">
        {{-- HTMX / Blade content goes here --}}
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<div
    id="counters-table-container"
    hx-get="/counters"
    hx-trigger="load, every 5s"
    hx-swap="innerHTML"
>
    @include('tasks._current_task', ['runningTask' => $runningTask])
</div>

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
        x-data="{ open: true }"
        :hx-trigger="open ? 'load, every 15s' : null"
        hx-swap="innerHTML"
    >
    </div>
@endif
<dialog id="startTaskModal" class="modal">
    <div class="modal-box modal-lg">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Start Task</h2>

            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
            </form>
        </div>

        <form
            method="POST"
            action="/tasks/start-task"
            class="edit-current-task-form"
        >
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
                    placeholder="Title (Required)"
                    required
                >
            </label>

            <label>
                Notes
                <textarea name="notes" rows="4">{{ old('notes') }}</textarea>
            </label>

            <button type="submit" class="btn btn-primary">
                Start
            </button>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
<dialog id="addBacklogEntryModal" class="modal">
    <div class="modal-box modal-lg">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Add Backlogged Entry</h2>

            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
            </form>
        </div>

        <form
            method="POST"
            action="/completed-tasks/add-completed-task"
            class="edit-current-task-form"
        >
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

            <label class="form-control w-full">
                <span class="label-text">Title</span>

                <input
                    type="text"
                    name="title"
                    maxlength="255"
                    placeholder="feat: add counter reset"
                    class="input input-bordered w-full"
                    required
                    pattern="^(feat|fix|docs|style|refactor|perf|test|chore)(\([a-z0-9\-]+\))?: .{1,}$"
                    title="Use Conventional Commits: type(scope?): description"
                />
            </label>

            <label>
                Duration (hours)
                <input
                    type="number"
                    step="0.25"
                    name="duration"
                    required
                >
            </label>

            <label>
                Notes
                <textarea name="notes" rows="4"></textarea>
            </label>

            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
