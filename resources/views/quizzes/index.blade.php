<x-layouts.app>
    @php($palette = config('quiz.palette', []))
    <section class="mb-10 space-y-3">
        <p class="text-sm uppercase tracking-wide text-zinc-400">Quizy</p>
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight text-zinc-900">Sprawdź swoją wiedzę</h1>
                <p class="text-sm text-zinc-500">
                    Wybierz quiz z listy, aby rozpocząć. Każdy z nich łączy pytania z PHP i ogólnego programowania.
                </p>
            </div>
            <a
                href="#"
                class="inline-flex items-center gap-2 text-sm font-medium text-zinc-400"
                title="Panel administracyjny wkrótce"
            >
                Panel admina (wkrótce)
            </a>
        </div>
    </section>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse($quizzes as $quiz)
            <article class="rounded-2xl border border-zinc-200 bg-white/80 p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-zinc-900">{{ $quiz->title }}</h2>
                        <p class="mt-2 text-sm text-zinc-500">{{ $quiz->description }}</p>
                    </div>
                    @if($quiz->time_limit)
                        <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs text-zinc-600">
                            {{ $quiz->time_limit }} min
                        </span>
                    @endif
                </div>

                <dl class="mt-6 grid grid-cols-2 gap-4 text-sm text-zinc-600">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-zinc-400">Pytania</dt>
                        <dd class="text-lg font-semibold text-zinc-900">{{ $quiz->questions_count }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-zinc-400">Tryb</dt>
                        <dd>{{ config('quiz.display_mode') === 'single' ? 'Pojedyncze' : 'Wszystkie naraz' }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a
                        href="{{ route('quizzes.show', $quiz) }}"
                        class="inline-flex w-full items-center justify-center rounded-xl px-4 py-2 text-sm font-semibold text-white shadow-sm transition {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}"
                    >
                        Rozpocznij quiz
                    </a>
                </div>
            </article>
        @empty
            <p class="text-sm text-zinc-500">Brak quizów. Panel admina pozwoli dodać nowe w przyszłości.</p>
        @endforelse
    </div>
</x-layouts.app>


