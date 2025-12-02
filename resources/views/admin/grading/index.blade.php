x-layouts.app>
    @php($palette = config('quiz.palette', []))

    <section class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-zinc-400">Admin · Ocena</p>
            <h1 class="text-2xl font-semibold text-zinc-900">Odpowiedzi otwarte</h1>
        </div>
        <div class="flex gap-2 text-xs">
            <a href="{{ route('admin.grading.index', ['status' => 'pending']) }}" class="rounded-full border px-3 py-1 {{ $status === 'pending' ? 'border-zinc-900 text-zinc-900' : 'border-zinc-200 text-zinc-500' }}">
                Niesprawdzone
            </a>
            <a href="{{ route('admin.grading.index', ['status' => 'reviewed']) }}" class="rounded-full border px-3 py-1 {{ $status === 'reviewed' ? 'border-zinc-900 text-zinc-900' : 'border-zinc-200 text-zinc-500' }}">
                Sprawdzone
            </a>
            <a href="{{ route('admin.grading.index', ['status' => 'all']) }}" class="rounded-full border px-3 py-1 {{ $status === 'all' ? 'border-zinc-900 text-zinc-900' : 'border-zinc-200 text-zinc-500' }}">
                Wszystkie
            </a>
        </div>
    </section>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white/80 text-sm">
        <table class="min-w-full divide-y divide-zinc-200">
            <thead class="bg-zinc-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Quiz</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Pytanie</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Odpowiedź</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Punkty</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">Status</th>
                <th class="px-4 py-2"></th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
            @forelse($responses as $response)
                <tr>
                    <td class="px-4 py-2 text-zinc-800">{{ $response->question->quiz->title }}</td>
                    <td class="px-4 py-2 text-zinc-800 line-clamp-2">{{ $response->question->question_text }}</td>
                    <td class="px-4 py-2 text-zinc-600 line-clamp-2">{{ $response->text_response }}</td>
                    <td class="px-4 py-2 text-zinc-800">
                        {{ $response->points_earned }} / {{ $response->question->points }}
                    </td>
                    <td class="px-4 py-2">
                        <span class="rounded-full px-3 py-1 text-xs font-medium {{ $response->manually_graded ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ $response->manually_graded ? 'Sprawdzone' : 'Do sprawdzenia' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('admin.grading.edit', $response) }}" class="text-xs font-medium text-zinc-500 hover:text-zinc-800">
                            Oceń
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-sm text-zinc-500">
                        Brak odpowiedzi spełniających kryteria filtra.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $responses->links() }}
    </div>
</x-layouts.app>


