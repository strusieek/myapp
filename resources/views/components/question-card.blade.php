@props([
    'question',
    'index' => 1,
    'displayMode' => 'all',
])

@php
    $inputName = "questions[{$question->id}]";
    $palette = config('quiz.palette', []);
@endphp

<section
    class="question-card rounded-2xl border border-zinc-200 bg-white/90 p-6 shadow-sm transition-all"
    data-question-card
    data-question-index="{{ $index }}"
>
    <header class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-wide text-zinc-400">Pytanie {{ $index }}</p>
            <h3 class="text-lg font-semibold text-zinc-900">{{ $question->question_text }}</h3>
            <p class="text-sm text-zinc-500">{{ $question->question_type->label() }}</p>
        </div>
        <div class="rounded-full border border-zinc-200 px-3 py-1 text-xs font-medium text-zinc-600">
            {{ $question->points }} pkt
        </div>
    </header>

    <div class="space-y-3">
        @if($question->isSelectable())
            @foreach($question->answers as $answer)
                <x-answer-option
                    :answer="$answer"
                    :question="$question"
                    name="{{ $inputName }}[selected_answer_id]"
                    :checked="(int) old('questions.' . $question->id . '.selected_answer_id') === $answer->id"
                />
            @endforeach
        @else
            <label class="block text-sm font-medium text-zinc-700" for="text-response-{{ $question->id }}">
                Twoja odpowiedź
            </label>
            <textarea
                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-800 transition focus:outline-none focus:ring-2 {{ $palette['focusBorder'] ?? 'focus:border-indigo-400' }} {{ $palette['focusRing'] ?? 'focus:ring-indigo-100' }}"
                name="{{ $inputName }}[text_response]"
                id="text-response-{{ $question->id }}"
                rows="4"
            >{{ old('questions.' . $question->id . '.text_response') }}</textarea>
        @endif

        @error("questions.{$question->id}." . ($question->isSelectable() ? 'selected_answer_id' : 'text_response'))
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</section>


