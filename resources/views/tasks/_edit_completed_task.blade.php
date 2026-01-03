<div class="modal-content">
    <span class="close"
          onclick="this.closest('.modal').classList.remove('visible')">
        &times;
    </span>
    <h2>Edit Completed Task</h2>
    <form
    class="edit-current-task-form"
    method="POST"
    action="/completed-tasks/{{ $completedTask->id }}"
    onsubmit="this.closest('.modal').classList.remove('visible')">

        @csrf
        @method('PUT')

        <label>
            Project
            <select name="project_id" required>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}"
                        @selected($project->id === $completedTask->project_id)>
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
                value="{{ old('title', $completedTask->title) }}"
            >
            </label>
        <label>
            Duration (hours)
            <input type="number"
                   step="0.01"
                   name="duration"
                   value="{{ $completedTask->duration }}"
                   required>
        </label>

        <label>
            Notes
            <textarea name="notes" rows="4">{{ $completedTask->notes }}</textarea>
        </label>

        <button type="submit">
            💾 Save changes
        </button>
    </form>
    <form
        class="form-row"
        method="POST"
        action="/completed-tasks/{{ $completedTask->id }}"
        onsubmit="
            if (!confirm('Delete this completed task?')) return false;
            this.closest('.modal').classList.remove('visible');
        "
        style="margin-top: 1rem;"
    >
        @csrf
        @method('DELETE')

        <button type="submit" style="color: red;">
            🗑️ Delete
        </button>
    </form>
</div>
