<div class="space-y-4">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">
            Edit Completed Task: {{ $completedTask->title }}
        </h2>

        {{-- Close button --}}
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
        </form>
    </div>

    {{-- Edit form --}}
    <form
        class="edit-current-task-form"
        method="POST"
        action="/completed-tasks/{{ $completedTask->id }}"
    >
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
            <input
                type="number"
                step="0.01"
                name="duration"
                value="{{ $completedTask->duration }}"
                required
            >
        </label>

        <label>
            Notes
            <textarea name="notes" rows="4">{{ trim($completedTask->notes) }}</textarea>
        </label>

        <button type="submit" class="btn btn-success">
            💾 Save
        </button>
    </form>

    <div class="divider"></div>

    {{-- Delete form --}}
    <form
        method="POST"
        action="/completed-tasks/{{ $completedTask->id }}"
        x-data="{
            armed: false,
            timer: null,
            arm() {
                this.armed = true
                this.timer = setTimeout(() => {
                    this.armed = false
                }, 3000)
            }
        }"
        @submit.prevent="
            if (!armed) {
                arm()
            } else {
                $el.submit()
            }
        "
    >
        @csrf
        @method('DELETE')

    <button
        type="submit"
        class="btn transition-all duration-200"
        :class="armed
            ? 'bg-red-700 hover:bg-red-800 text-white border-red-700 animate-pulse shadow-[0_0_16px_oklch(var(--er)/0.45)]'
            : 'btn-error btn-outline'"
    >
        <span x-show="!armed">🗑️ Delete</span>
        <span x-show="armed">⚠️ Confirm</span>
    </button>
    </form>
</div>
