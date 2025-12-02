<x-layouts.app>
    @php($palette = config('quiz.palette', []))

    <section class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-zinc-400">Admin · Quizy</p>
            <h1 class="text-2xl font-semibold text-zinc-900">Zarządzanie quizami</h1>
        </div>
        <a href="{{ route('admin.quizzes.create') }}" class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-semibold text-white shadow-sm {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}">
            Nowy quiz
        </a>
    </section>

    <form method="GET" class="mb-4 flex flex-col gap-3 rounded-2xl border border-zinc-200 bg-white/80 p-4 text-sm md:flex-row md:items-end md:justify-between">
        <div class="flex flex-1 flex-col gap-1 md:max-w-xs">
            <label for="search" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Szukaj</label>
            <input id="search" name="search" value="{{ request('search') }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}" placeholder="Tytuł lub kategoria">
        </div>
        <div class="flex flex-1 flex-col gap-1 md:max-w-xs">
            <label for="active" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Status</label>
            <select id="active" name="active" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                <option value="">Wszystkie</option>
                <option value="1" @selected(request('active') === '1')>Aktywne</option>
                <option value="0" @selected(request('active') === '0')>Nieaktywne</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded-xl border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:border-zinc-300">
                Filtruj
            </button>
            <a href="{{ route('admin.quizzes.index') }}" class="rounded-xl border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-500 hover:border-zinc-300">
                Wyczyść
            </a>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white/80">
        <table class="min-w-full divide-y divide-zinc-200 text-sm">
            <thead class="bg-zinc-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Tytuł</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Kategoria</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Pytania</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Status</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Próg</th>
                <th class="px-4 py-2"></th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
            @forelse($quizzes as $quiz)
                <tr>
                    <td class="px-4 py-2">
                        <div class="font-medium text-zinc-900">{{ $quiz->title }}</div>
                        <div class="text-xs text-zinc-500">ID: {{ $quiz->id }}</div>
                    </td>
                    <td class="px-4 py-2 text-zinc-600">{{ $quiz->category ?? '—' }}</td>
                    <td class="px-4 py-2 text-zinc-600">{{ $quiz->questions_count }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.quizzes.toggle-active', $quiz) }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $quiz->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-zinc-100 text-zinc-600' }}">
                                {{ $quiz->is_active ? 'Aktywny' : 'Nieaktywny' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-2 text-zinc-600">
                        @if($quiz->pass_threshold)
                            {{ $quiz->pass_threshold }} pkt
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="text-xs font-medium text-zinc-500 hover:text-zinc-800">Edytuj</a>
                            <form method="POST" action="{{ route('admin.quizzes.duplicate', $quiz) }}" onsubmit="return confirm('Utworzyć kopię tego quizu?')">
                                @csrf
                                <button type="submit" class="text-xs font-medium text-zinc-400 hover:text-zinc-700">Duplikuj</button>
                            </form>
                            <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}" onsubmit="return confirm('Na pewno usunąć ten quiz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-rose-500 hover:text-rose-700">Usuń</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-sm text-zinc-500">Brak quizów. Utwórz pierwszy, aby rozpocząć.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $quizzes->links() }}
    </div>
</x-layouts.app>


