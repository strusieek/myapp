<x-layouts.app>
    @php($palette = config('quiz.palette', []))

    <section class="mb-6">
        <p class="text-sm uppercase tracking-wide text-zinc-400">Admin · Quizy</p>
        <h1 class="text-2xl font-semibold text-zinc-900">Nowy quiz</h1>
    </section>

    <form method="POST" action="{{ route('admin.quizzes.store') }}" class="space-y-6 rounded-2xl border border-zinc-200 bg-white/80 p-6 text-sm">
        @csrf

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-1">
                <label for="title" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Tytuł</label>
                <input id="title" name="title" value="{{ old('title') }}" required class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                @error('title') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="category" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Kategoria</label>
                <input id="category" name="category" value="{{ old('category') }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}" placeholder="np. PHP, Algorytmy">
                @error('category') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-1">
            <label for="description" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Opis</label>
            <textarea id="description" name="description" rows="3" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="space-y-1">
                <label for="time_limit" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Limit czasu (minuty)</label>
                <input id="time_limit" name="time_limit" type="number" min="1" step="1" value="{{ old('time_limit') }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                @error('time_limit') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="pass_threshold" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Próg zaliczenia (pkt)</label>
                <input id="pass_threshold" name="pass_threshold" type="number" min="0" step="1" value="{{ old('pass_threshold') }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                @error('pass_threshold') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="max_attempts" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Maks. prób</label>
                <input id="max_attempts" name="max_attempts" type="number" min="1" step="1" value="{{ old('max_attempts') }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                @error('max_attempts') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <span class="text-xs font-medium uppercase tracking-wide text-zinc-500">Opcje</span>
                <div class="mt-1 space-y-1">
                    <label class="flex items-center gap-2 text-xs text-zinc-700">
                        <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}" checked>
                        Aktywny
                    </label>
                    <label class="flex items-center gap-2 text-xs text-zinc-700">
                        <input type="checkbox" name="randomize_questions" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}">
                        Losowa kolejność pytań
                    </label>
                    <label class="flex items-center gap-2 text-xs text-zinc-700">
                        <input type="checkbox" name="randomize_answers" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}">
                        Losowa kolejność odpowiedzi
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.quizzes.index') }}" class="rounded-xl border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 hover:border-zinc-300">
                Anuluj
            </a>
            <button type="submit" class="rounded-xl px-4 py-2 text-sm font-semibold text-white shadow-sm {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}">
                Zapisz quiz
            </button>
        </div>
    </form>
</x-layouts.app>


