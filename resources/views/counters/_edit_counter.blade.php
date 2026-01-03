<div class="modal-content">
    <h2>{{ $counter->name }}</h2>

    <p>
        {{ $counter->entries->count() }}
        /
        {{ $counter->goal ?? '–' }}
    </p>

    <form
        class="form-row"
        hx-post="/counters/{{ $counter->id }}/entries"
        hx-target="#editCounterModal"
        hx-swap="innerHTML"
    >
        @csrf
        <button type="submit">
            ➕ Add Entry
        </button>
    </form>
        @foreach ($counter->entries as $entry)
            <div class = "edit-counter-entry-row">
                <form
                    hx-patch="/counters/{{ $entry->id }}"
                    hx-target="#editCounterModal"
                    hx-swap="innerHTML"
                >
                    @csrf
                    @method('PATCH')

                    <small class="form-hint">
                        {{ $entry->created_at->format('Y-m-d') }}
                    </small>
                    <label>
                        <input
                            class="edit-counter-entry-note-textarea"
                            type="text"
                            name="note"
                            value="{{ $entry->note }}"
                            placeholder="Add note…"
                        />
                    </label>

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
            </div>
        @endforeach

    <span class="close"
          onclick="this.closest('.modal').classList.remove('visible')">
        &times;
    </span>
</div>

