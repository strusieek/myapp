<x-layouts.app>
    @php($palette = config('quiz.palette', []))

    <section class="mb-6">
        <p class="text-sm uppercase tracking-wide text-zinc-400">Admin · Ocena</p>
        <h1 class="text-2xl font-semibold text-zinc-900">Oceń odpowiedź</h1>
    </section>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white/80 p-6 text-sm lg:col-span-2">
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-400">Quiz</p>
                <p class="text-sm font-medium text-zinc-800">{{ $question->quiz->title }}</p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-400">Pytanie</p>
                <p class="mt-1 text-sm font-medium text-zinc-900">{{ $question->question_text }}</p>
                @if($question->explanation)
                    <p class="mt-2 text-xs text-zinc-500">Opis / wskazówki: {{ $question->explanation }}</p>
                @endif
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-400">Wzorcowa odpowiedź</p>
                <p class="mt-1 text-sm text-zinc-800">
                    @php($expected = $question->answers->firstWhere('is_correct', true))
                    {{ $expected?->answer_text ?? 'Brak zdefiniowanej odpowiedzi wzorcowej.' }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-400">Odpowiedź użytkownika</p>
                <p class="mt-1 whitespace-pre-wrap rounded-xl bg-zinc-50 px-3 py-2 text-sm text-zinc-800">
                    {{ $response->text_response ?: 'Brak odpowiedzi.' }}
                </p>
            </div>
        </section>

        <form method="POST" action="{{ route('admin.grading.update', $response) }}" class="space-y-4 rounded-2xl border border-zinc-200 bg-white/80 p-6 text-sm">
            @csrf
            @method('PUT')

            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-400">Przyznaj punkty</p>
                <p class="mt-1 text-sm text-zinc-600">Zakres: 0 – {{ $question->points }} pkt</p>
                <input type="number" name="points_earned" min="0" max="{{ $question->points }}" value="{{ old('points_earned', $response->points_earned) }}" class="mt-2 w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                @error('points_earned') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-400">Komentarz / feedback</p>
                <textarea name="feedback" rows="4" class="mt-2 w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">{{ old('feedback', $response->feedback) }}</textarea>
                @error('feedback') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-2 text-xs text-zinc-600">
                <p>
                    Aktualne punkty w podejściu: <span class="font-medium text-zinc-900">{{ $response->attempt->score }}</span>
                    / {{ $response->attempt->total_points }}
                </p>
                @if($response->manually_graded)
                    <p>
                        Ocenione: {{ $response->reviewed_at?->format('d.m.Y H:i') }}
                    </p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.grading.index') }}" class="rounded-xl border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 hover:border-zinc-300">
                    Anuluj
                </a>
                <button type="submit" class="rounded-xl px-4 py-2 text-sm font-semibold text-white shadow-sm {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}">
                    Zapisz ocenę
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>


