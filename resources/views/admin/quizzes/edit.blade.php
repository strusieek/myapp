<x-layouts.app>
    @php($palette = config('quiz.palette', []))

    <section class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-wide text-zinc-400">Admin · Quizy</p>
            <h1 class="text-2xl font-semibold text-zinc-900">Edytuj quiz</h1>
            <p class="text-sm text-zinc-500">ID: {{ $quiz->id }}</p>
        </div>
        <a href="{{ route('admin.quizzes.index') }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-800">
            &larr; Lista quizów
        </a>
    </section>

    <div class="grid gap-6 lg:grid-cols-3">
        <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="space-y-6 rounded-2xl border border-zinc-200 bg-white/80 p-6 text-sm lg:col-span-2">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label for="title" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Tytuł</label>
                    <input id="title" name="title" value="{{ old('title', $quiz->title) }}" required class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    @error('title') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label for="category" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Kategoria</label>
                    <input id="category" name="category" value="{{ old('category', $quiz->category) }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    @error('category') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-1">
                <label for="description" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Opis</label>
                <textarea id="description" name="description" rows="3" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">{{ old('description', $quiz->description) }}</textarea>
                @error('description') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-4">
                <div class="space-y-1">
                    <label for="time_limit" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Limit czasu (minuty)</label>
                    <input id="time_limit" name="time_limit" type="number" min="1" step="1" value="{{ old('time_limit', $quiz->time_limit) }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    @error('time_limit') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label for="pass_threshold" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Próg zaliczenia (pkt)</label>
                    <input id="pass_threshold" name="pass_threshold" type="number" min="0" step="1" value="{{ old('pass_threshold', $quiz->pass_threshold) }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    @error('pass_threshold') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label for="max_attempts" class="text-xs font-medium uppercase tracking-wide text-zinc-500">Maks. prób</label>
                    <input id="max_attempts" name="max_attempts" type="number" min="1" step="1" value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    @error('max_attempts') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <span class="text-xs font-medium uppercase tracking-wide text-zinc-500">Opcje</span>
                    <div class="mt-1 space-y-1">
                        <label class="flex items-center gap-2 text-xs text-zinc-700">
                            <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}" @checked(old('is_active', $quiz->is_active))>
                            Aktywny
                        </label>
                        <label class="flex items-center gap-2 text-xs text-zinc-700">
                            <input type="checkbox" name="randomize_questions" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}" @checked(old('randomize_questions', $quiz->randomize_questions))>
                            Losowa kolejność pytań
                        </label>
                        <label class="flex items-center gap-2 text-xs text-zinc-700">
                            <input type="checkbox" name="randomize_answers" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}" @checked(old('randomize_answers', $quiz->randomize_answers))>
                            Losowa kolejność odpowiedzi
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="rounded-xl px-4 py-2 text-sm font-semibold text-white shadow-sm {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}">
                    Zapisz zmiany
                </button>
            </div>
        </form>

        <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white/80 p-4 text-sm">
            <header class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-zinc-800">Pytania</h2>
            </header>

            <form method="POST" action="{{ route('admin.questions.store', $quiz) }}" class="space-y-3 rounded-xl border border-dashed border-zinc-200 bg-zinc-50/80 p-3">
                @csrf
                <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Dodaj pytanie</p>
                <div class="space-y-1">
                    <label class="text-xs text-zinc-600">Treść pytania</label>
                    <textarea name="question_text" rows="2" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">{{ old('question_text') }}</textarea>
                </div>
                <div class="grid gap-2 md:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-xs text-zinc-600">Typ pytania</label>
                        <select name="question_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                            @foreach($questionTypes as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs text-zinc-600">Punkty</label>
                        <input type="number" name="points" value="{{ old('points', 1) }}" min="1" max="100" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <label class="flex items-center gap-2 text-xs text-zinc-700">
                        <input type="checkbox" name="allow_multiple_answers" value="1" class="h-4 w-4 rounded border-zinc-300 {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}">
                        Wielokrotny wybór
                    </label>
                    <div class="space-y-1">
                        <label class="text-xs text-zinc-600">Limit czasu (sek.)</label>
                        <input type="number" name="time_limit" value="{{ old('time_limit') }}" min="1" max="3600" class="w-28 rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs text-zinc-800 focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}">
                    </div>
                </div>
                <button type="submit" class="w-full rounded-lg px-3 py-2 text-xs font-semibold text-white shadow-sm {{ $palette['bgSolid'] ?? 'bg-indigo-600' }} {{ $palette['bgHover'] ?? 'hover:bg-indigo-700' }}">
                    Dodaj pytanie
                </button>
            </form>

            <div class="space-y-3">
                @forelse($quiz->questions as $question)
                    <article class="space-y-2 rounded-xl border border-zinc-200 bg-white p-3">
                        <header class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-zinc-400">Pytanie {{ $question->display_order }}</p>
                                <p class="text-sm font-medium text-zinc-900 break-words">{{ $question->question_text }}</p>
                                <p class="text-xs text-zinc-500">
                                    {{ $question->question_type->label() }} · {{ $question->points }} pkt
                                    @if($question->allow_multiple_answers)
                                        · wielokrotny wybór
                                    @endif
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <form method="POST" action="{{ route('admin.questions.up', [$quiz, $question]) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-zinc-400 hover:text-zinc-700">&uarr;</button>
                                </form>
                                <form method="POST" action="{{ route('admin.questions.down', [$quiz, $question]) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-zinc-400 hover:text-zinc-700">&darr;</button>
                                </form>
                            </div>
                        </header>

                        <details class="text-xs text-zinc-600">
                            <summary class="cursor-pointer text-xs font-medium text-zinc-700">Edycja pytania</summary>
                            <form method="POST" action="{{ route('admin.questions.update', [$quiz, $question]) }}" class="mt-2 space-y-2">
                                @csrf
                                @method('PUT')
                                <textarea name="question_text" rows="2" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs text-zinc-800">{{ $question->question_text }}</textarea>
                                <div class="grid gap-2 md:grid-cols-2">
                                    <div>
                                        <label class="text-xs text-zinc-600">Typ</label>
                                        <select name="question_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs text-zinc-800">
                                            @foreach($questionTypes as $type)
                                                <option value="{{ $type->value }}" @selected($question->question_type === $type)>{{ $type->label() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs text-zinc-600">Punkty</label>
                                        <input type="number" name="points" value="{{ $question->points }}" min="1" max="100" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs text-zinc-800">
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="flex items-center gap-2 text-xs text-zinc-700">
                                        <input type="checkbox" name="allow_multiple_answers" value="1" class="h-4 w-4 rounded border-zinc-300" @checked($question->allow_multiple_answers)>
                                        Wielokrotny wybór
                                    </label>
                                    <div>
                                        <label class="text-xs text-zinc-600">Limit czasu (sek.)</label>
                                        <input type="number" name="time_limit" value="{{ $question->time_limit }}" min="1" max="3600" class="w-28 rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs text-zinc-800">
                                    </div>
                                </div>
                                <button type="submit" class="rounded-lg px-3 py-1 text-xs font-semibold text-white {{ $palette['bgSolid'] ?? 'bg-indigo-600' }}">
                                    Zapisz pytanie
                                </button>
                            </form>
                        </details>

                        <div class="mt-2 border-t border-zinc-100 pt-2">
                            <p class="mb-1 text-xs font-medium text-zinc-700">Odpowiedzi</p>
                            <div class="space-y-1">
                                @foreach($question->answers as $answer)
                                    <form method="POST" action="{{ route('admin.answers.update', [$quiz, $question, $answer]) }}" class="flex items-center gap-2 text-xs">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="answer_text" value="{{ $answer->answer_text }}" class="flex-1 rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs text-zinc-800">
                                        <label class="flex items-center gap-1 text-[11px] text-zinc-700">
                                            <input type="checkbox" name="is_correct" value="1" class="h-3 w-3 rounded border-zinc-300" @checked($answer->is_correct)>
                                            poprawna
                                        </label>
                                        <input type="text" name="explanation" value="{{ $answer->explanation }}" placeholder="Wyjaśnienie" class="hidden md:block w-40 rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs text-zinc-800">
                                        <button type="submit" class="text-[11px] text-zinc-500 hover:text-zinc-800">Zapisz</button>
                                        <form method="POST" action="{{ route('admin.answers.destroy', [$quiz, $question, $answer]) }}" onsubmit="return confirm('Usunąć odpowiedź?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[11px] text-rose-500 hover:text-rose-700">Usuń</button>
                                        </form>
                                    </form>
                                @endforeach
                            </div>

                            <form method="POST" action="{{ route('admin.answers.store', [$quiz, $question]) }}" class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                                @csrf
                                <input type="text" name="answer_text" placeholder="Nowa odpowiedź" class="flex-1 rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs text-zinc-800">
                                <label class="flex items-center gap-1 text-[11px] text-zinc-700">
                                    <input type="checkbox" name="is_correct" value="1" class="h-3 w-3 rounded border-zinc-300">
                                    poprawna
                                </label>
                                <button type="submit" class="rounded-lg px-3 py-1 text-[11px] font-semibold text-white {{ $palette['bgSolid'] ?? 'bg-indigo-600' }}">
                                    Dodaj
                                </button>
                            </form>
                        </div>

                        <form method="POST" action="{{ route('admin.questions.destroy', [$quiz, $question]) }}" onsubmit="return confirm('Na pewno usunąć to pytanie?')" class="mt-2 text-right">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[11px] font-medium text-rose-500 hover:text-rose-700">
                                Usuń pytanie
                            </button>
                        </form>
                    </article>
                @empty
                    <p class="text-xs text-zinc-500">Brak pytań. Dodaj pierwsze powyżej.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.app>


