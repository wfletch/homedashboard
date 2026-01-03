<table border="1" cellpadding="6">
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
            <td>{{ $counter->name }}</td>
            <td>{{ $counter->goal ?? '–' }}</td>
            <td>{{ $counter->entries_count }}</td>
            <td>
                {{ optional($counter->last_entry_at)?->format('Y-m-d') ?? '–' }}
            </td>
            <td>
                <button
                    hx-get="/counters/{{ $counter->id }}/edit"
                    hx-target="#editCounterModal"
                    hx-swap="innerHTML">
                    ⓘ
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
