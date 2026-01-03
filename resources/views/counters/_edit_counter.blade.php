<div class="space-y-4">

    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">
            {{ $counter->name }}
        </h2>

        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
        </form>
    </div>

    <p class="text-sm opacity-70">
        {{ $counter->entries->count() }}
        /
        {{ $counter->goal ?? '–' }}
    </p>

    {{-- Add Entry --}}
    <form
        class="flex gap-2"
        hx-post="/counters/{{ $counter->id }}/entries"
        hx-target="#editCounterModalContent"
        hx-swap="innerHTML"
    >
        @csrf
        <button class="btn btn-sm btn-primary">
            ➕ Add Entry
        </button>
    </form>

    <div class="divider"></div>

    {{-- Entries --}}
    @foreach ($counter->entries as $entry)
        <div class="flex gap-2 items-start">

            {{-- Update --}}
            <form
                class="flex gap-2 flex-1"
                hx-patch="/counters/{{ $entry->id }}"
                hx-target="#editCounterModalContent"
                hx-swap="innerHTML"
            >
                @csrf
                @method('PATCH')

                <input
                    type="text"
                    name="note"
                    value="{{ $entry->note }}"
                    placeholder="Add note…"
                    class="input input-sm input-bordered flex-1"
                />

                <button class="btn btn-sm btn-outline">
                    💾
                </button>
            </form>

            {{-- Delete --}}
            <form
                x-data="{
                    armed: false,
                    timer: null,
                    arm() {
                        this.armed = true
                        clearTimeout(this.timer)
                        this.timer = setTimeout(() => this.armed = false, 3000)
                    },
                    confirm() {
                        if (!this.armed) {
                            this.arm()
                        } else {
                            htmx.trigger(this.$el, 'confirmed')
                        }
                    }
                }"
                hx-delete="/counters/{{ $entry->id }}"
                hx-trigger="confirmed"
                hx-target="#editCounterModalContent"
                hx-swap="innerHTML"
            >
                @csrf
                @method('DELETE')

                <button
                    type="button"
                    @click="confirm()"
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
    @endforeach

</div>
