<x-layouts.app>
    @php($palette = config('quiz.palette', []))

    <section class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-zinc-400">Panel admina</p>
            <h1 class="text-3xl font-semibold text-zinc-900">Dashboard</h1>
            <p class="text-sm text-zinc-500">Podsumowanie aktywności w systemie quizów.</p>
        </div>
        <div class="flex flex-wrap gap-2 text-sm">
            <a href="{{ route('admin.quizzes.index') }}" class="rounded-xl border border-zinc-200 px-3 py-1 text-zinc-600 hover:border-zinc-300">
                Zarządzaj quizami
            </a>
        </div>
    </section>

    <section class="space-y-3">
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white/80">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead class="bg-zinc-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Quiz</th>
                    <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Kategoria</th>
                    <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Podejścia</th>
                    <th class="px-4 py-2"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                @forelse($popularQuizzes as $quiz)
                    <tr>
                        <td class="px-4 py-2 text-zinc-800">{{ $quiz->title }}</td>
                        <td class="px-4 py-2 text-zinc-500">{{ $quiz->category ?? '—' }}</td>
                        <td class="px-4 py-2 text-zinc-800">{{ $quiz->attempts_count }}</td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="text-xs font-medium text-zinc-500 hover:text-zinc-800">Edytuj</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-sm text-zinc-500">
                            Brak danych – użytkownicy jeszcze nie rozwiązywali quizów.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.app>


