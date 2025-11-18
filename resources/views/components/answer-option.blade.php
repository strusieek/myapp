@props([
    'answer',
    'question',
    'name',
    'checked' => false,
])

@php
    $inputId = "answer-{$question->id}-{$answer->id}";
    $palette = config('quiz.palette', []);
@endphp

<label
    for="{{ $inputId }}"
    class="flex cursor-pointer items-center gap-3 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-800 transition {{ $palette['borderHover'] ?? 'hover:border-indigo-300' }}"
>
    <input
        type="radio"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $answer->id }}"
        @checked($checked)
        class="h-4 w-4 border-zinc-300 {{ $palette['radioColor'] ?? 'text-indigo-600' }} {{ $palette['radioRing'] ?? 'focus:ring-indigo-500' }}"
    >
    <span>{{ $answer->answer_text }}</span>
</label>


