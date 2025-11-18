<x-layouts.app>
    @php($palette = config('quiz.palette', []))
    <div class="mb-8 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-zinc-400">Quiz</p>
            <h1 class="text-3xl font-semibold text-zinc-900">{{ $quiz->title }}</h1>
            <p class="text-sm text-zinc-500">{{ $quiz->description }}</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-zinc-500">
            <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-700">
                {{ $quiz->questions->count() }} pytań
            </span>
            @if($quiz->time_limit)
                <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-700">
                    Limit: {{ $quiz->time_limit }} min
                </span>
            @endif
        </div>
    </div>

    <div class="mb-8 rounded-2xl border border-dashed border-zinc-300 bg-white/60 p-5 text-sm text-zinc-600">
        <p class="font-medium text-zinc-800">Instrukcje</p>
        <ul class="mt-3 list-disc space-y-1 pl-5">
            <li>Odpowiadaj zgodnie z typem pytania (wielokrotny wybór, P/F, krótka odpowiedź).</li>
            <li>Zatwierdź quiz przyciskiem „Zakończ i sprawdź wynik”.</li>
            <li>Twoje odpowiedzi zostaną zapisane dla przyszłej analityki admina.</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('quizzes.submit', $quiz) }}" class="space-y-8" id="quiz-form">
        @csrf

        @if($displayMode === 'single')
            <div class="rounded-2xl border border-zinc-200 bg-white/80 p-4 text-sm text-zinc-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-zinc-400">Tryb</p>
                        <p class="font-medium text-zinc-800">Pytanie <span data-progress-current>1</span> z {{ $questionCount }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" data-single-prev class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-500 disabled:opacity-40">
                            Poprzednie
                        </button>
                        <button type="button" data-single-next class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-500">
                            Następne
                        </button>
                    </div>
                </div>
                <div class="mt-4 h-2 w-full rounded-full bg-zinc-100">
                    <div class="h-full rounded-full transition-all {{ $palette['progress'] ?? 'bg-indigo-500' }}" data-progress-bar style="width: {{ $questionCount ? 100 / $questionCount : 0 }}%"></div>
                </div>
            </div>
        @endif

        <div class="space-y-6" data-question-wrapper data-display-mode="{{ $displayMode }}">
            @foreach($quiz->questions as $question)
                <x-question-card
                    :question="$question"
                    :index="$loop->iteration"
                    :display-mode="$displayMode"
                />
            @endforeach
        </div>

        <div class="flex flex-col gap-3 border-t border-zinc-200 pt-6 sm:flex-row sm:justify-between">
            <a href="{{ route('quizzes.index') }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-700">
                Wróć do listy quizów
            </a>
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-semibold text-white shadow-sm transition {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}"
            >
                Zakończ i sprawdź wynik
            </button>
        </div>
    </form>

    @if($displayMode === 'single')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const cards = Array.from(document.querySelectorAll('[data-question-card]'));
                if (!cards.length) return;
                let current = 0;
                const total = cards.length;
                const prevBtn = document.querySelector('[data-single-prev]');
                const nextBtn = document.querySelector('[data-single-next]');
                const progressCurrent = document.querySelector('[data-progress-current]');
                const progressBar = document.querySelector('[data-progress-bar]');

                const sync = () => {
                    cards.forEach((card, index) => {
                        card.classList.toggle('hidden', index !== current);
                    });
                    if (progressCurrent) {
                        progressCurrent.textContent = current + 1;
                    }
                    if (progressBar) {
                        progressBar.style.width = `${((current + 1) / total) * 100}%`;
                    }
                    if (prevBtn) prevBtn.disabled = current === 0;
                    if (nextBtn) nextBtn.disabled = current === total - 1;
                };

                prevBtn?.addEventListener('click', () => {
                    if (current > 0) {
                        current -= 1;
                        sync();
                    }
                });

                nextBtn?.addEventListener('click', () => {
                    if (current < total - 1) {
                        current += 1;
                        sync();
                    }
                });

                sync();
            });
        </script>
    @endif
</x-layouts.app>


