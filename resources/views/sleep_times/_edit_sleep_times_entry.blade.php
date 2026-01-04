<div class="space-y-4">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">
            Edit Sleep Time
        </h2>

        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
        </form>
    </div>

    {{-- Meta --}}
    <p class="text-sm opacity-70">
        {{ $sleepTime->day->toFormattedDateString() }}
    </p>

    {{-- Update --}}
<form
    hx-patch="/sleep-times/{{ $sleepTime->id }}"
    hx-target="#editSleepTimesModalContent"
    hx-swap="none"
    class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end"
>
    @csrf
    @method('PATCH')

    <div class="flex flex-col gap-1">
        <label class="text-xs opacity-60">Day</label>
        <input
            type="date"
            name="day"
            value="{{ $sleepTime->day->toDateString() }}"
            class="input input-sm input-bordered w-full"
        />
    </div>

    <div class="flex flex-col gap-1">
        <label class="text-xs opacity-60">Bed Time</label>
        <input
            type="time"
            name="bed_time"
            value="{{ $sleepTime->bed_time }}"
            class="input input-sm input-bordered w-full"
        />
    </div>

    <div class="flex flex-col gap-1">
        <label class="text-xs opacity-60">Wake Time</label>
        <input
            type="time"
            name="wake_time"
            value="{{ $sleepTime->wake_time }}"
            class="input input-sm input-bordered w-full"
        />
    </div>

    <button type="submit" class="btn btn-sm btn-outline w-full">
        💾 Save
    </button>
</form>
    <div class="divider"></div>

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
    hx-delete="/sleep-times/{{ $sleepTime->id }}"
    hx-trigger="confirmed"
    hx-target="#editSleepTimesModalContent"
    hx-swap="none"
>
    @csrf
    @method('DELETE')

    <button
        type="button"
        @click="confirm()"
        class="btn transition-all duration-200 w-full"
        :class="armed
            ? 'bg-red-700 hover:bg-red-800 text-white border-red-700 animate-pulse shadow-[0_0_16px_oklch(var(--er)/0.45)]'
            : 'btn-error btn-outline'"
    >
        <span x-show="!armed">🗑️ Delete</span>
        <span x-show="armed">⚠️ Confirm Delete</span>
    </button>

</div>
