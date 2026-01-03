<div x-data="{ open: true }" class="my-12">

    <!-- Counters header (clickable) -->
    <button
        type="button"
        class="w-full text-center focus:outline-none"
        @click="open = !open"
    >
        <div class="text-2xl font-bold">
            Counters
        </div>

        <!-- south accent -->
        <div
            class="mt-3 h-1 w-32 mx-auto rounded-full bg-pink-300
                   transition-all duration-300"
            :class="open ? 'opacity-100' : 'opacity-40 w-20'"
        ></div>
    </button>

    <!-- Collapsible table -->
    <div
        x-show="open"
        x-transition
        x-cloak
        class="mt-6"
    >
        <table class="table table-bordered w-full">
            <thead>
                <tr>
                    <th>Counter Name</th>
                    <th>Goal</th>
                    <th>Progress</th>
                    <th>Last Entry</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($counters as $counter)
                    <tr>
                        <td>{{ $counter->name }}</td>
                        <td>{{ $counter->goal ?? '–' }}</td>
                        <td>{{ $counter->entries_count }}</td>
                        <td>
                            {{ optional($counter->last_entry_at)?->format('Y-m-d') ?? '–' }}
                        </td>
                        <td>
                            <button
                                class="btn btn-outline"
                                hx-get="/counters/{{ $counter->id }}/edit"
                                hx-target="#editCounterModalContent"
                                _="on htmx:afterOnLoad call editCounterModal.showModal()"
                            >
                                ⓘ
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
