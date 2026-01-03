<div class="modal-content">
    <h2>{{ $counter->name }}</h2>

    <p>
        {{ $counter->entries->count() }}
        /
        {{ $counter->goal ?? '–' }}
    </p>

    <form
        hx-post="/counters/{{ $counter->id }}/entries"
        hx-target="#editCounterModal"
        hx-swap="innerHTML"
    >
        @csrf
        <button type="submit">
            ➕ Add Entry
        </button>
    </form>

    <ul>
        @foreach ($counter->entries as $entry)
        <li>
            {{ $entry->created_at->format('Y-m-d') }}
            <form
                hx-patch="/counters/{{ $entry->id }}"
                hx-target="#editCounterModal"
                hx-swap="innerHTML"
            >
                @csrf
                @method('PATCH')

                <input
                    type="text"
                    name="note"
                    value="{{ $entry->note }}"
                    placeholder="Add note…"
                />

                <button type="submit">💾</button>
            </form>
            <form
                hx-delete="/counters/{{ $entry->id }}"
                hx-confirm="Delete this entry?"
                hx-target="#editCounterModal"
                hx-swap="innerHTML"
                style="display:inline"
            >
                @csrf
                @method('DELETE')
                <button type="submit">
                    🗑
                </button>
            </form>
        </li>
        @endforeach
    </ul>

    <span class="close"
          onclick="this.closest('.modal').classList.remove('visible')">
        &times;
    </span>
</div>

