<x-layouts.app>
    <section class="mb-10 rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-wide text-zinc-400">Wynik</p>
                <h1 class="text-3xl font-semibold text-zinc-900">{{ $quiz->title }}</h1>
                <p class="text-sm text-zinc-500">Ukończono {{ $attempt->completed_at?->format('d.m.Y H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs uppercase tracking-wide text-zinc-400">Twój wynik</p>
                <p class="text-4xl font-semibold text-zinc-900">{{ $attempt->formattedScore() }}</p>
                <p class="text-sm text-zinc-500">{{ round(($attempt->score / max($attempt->total_points, 1)) * 100) }}%</p>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-4 text-sm text-zinc-600">
            <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-700">
                Pytania: {{ $quiz->questions->count() }}
            </span>
            <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-700">
                Poprawne: {{ $responses->where('is_correct', true)->count() }}
            </span>
            <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-700">
                Tryb: {{ config('quiz.display_mode') === 'single' ? 'Pojedyncze pytania' : 'Wszystkie naraz' }}
            </span>
        </div>
    </section>

    <section class="space-y-4">
        <p class="text-sm uppercase tracking-wide text-zinc-400">Twoje odpowiedzi</p>
        @foreach($responses as $response)
            @php
                $question = $response->question;
                $correctAnswer = $question->answers->firstWhere('is_correct', true);
            @endphp
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-5">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <h3 class="text-base font-semibold text-zinc-900">{{ $question->question_text }}</h3>
                    <span class="rounded-full {{ $response->is_correct ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} px-3 py-1 text-xs font-medium">
                        {{ $response->is_correct ? 'Dobrze' : 'Źle' }} · {{ $response->points_earned }} / {{ $question->points }} pkt
                    </span>
                </div>
                <div class="mt-3 space-y-2 text-sm text-zinc-600">
                    <p>
                        <span class="font-medium text-zinc-800">Twoja odpowiedź:</span>
                        @if($question->isSelectable())
                            {{ $response->selectedAnswer?->answer_text ?? 'Brak odpowiedzi' }}
                        @else
                            {{ $response->text_response ?? 'Brak odpowiedzi' }}
                        @endif
                    </p>
                    @if($correctAnswer)
                        <p>
                            <span class="font-medium text-zinc-800">Poprawna odpowiedź:</span>
                            {{ $correctAnswer->answer_text }}
                        </p>
                    @endif
                </div>
            </article>
        @endforeach
    </section>

    <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:justify-between">
        <a href="{{ route('quizzes.show', $quiz) }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-700">
            Spróbuj ponownie
        </a>
        <a
            href="{{ route('quizzes.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-zinc-200 px-6 py-3 text-sm font-semibold text-zinc-700 hover:border-zinc-300"
        >
            Wróć do listy quizów
        </a>
    </div>
</x-layouts.app>


