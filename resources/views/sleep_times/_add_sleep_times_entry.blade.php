<div class="space-y-4">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">
            Add Sleep Entry
        </h2>

        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
        </form>
    </div>

    <form
        hx-post="/sleep-times"
        hx-target="#addNewSleepTimesModalContent"
        hx-swap="none"
        class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end"
        onsubmit="this.closest('dialog').close()"
    >
        @csrf

        <div class="flex flex-col gap-1">
            <label class="text-xs opacity-60">Day</label>
            <input
                type="date"
                name="day"
                required
                class="input input-sm input-bordered w-full"
            />
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs opacity-60">Bed Time</label>
            <input
                type="time"
                name="bed_time"
                required
                class="input input-sm input-bordered w-full"
            />
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs opacity-60">Wake Time</label>
            <input
                type="time"
                name="wake_time"
                required
                class="input input-sm input-bordered w-full"
            />
        </div>

        <button class="btn btn-sm btn-primary w-full">
            ➕ Add
        </button>
    </form>

</div>
