<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Quiz') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-50 text-zinc-900 antialiased">
    @php
        $accentKey = config('quiz.accent_color', 'indigo');
        $palettes = [
            'indigo' => [
                'bgSolid' => 'bg-indigo-600',
                'bgHover' => 'hover:bg-indigo-700',
                'borderSoft' => 'border-indigo-200',
                'borderHover' => 'hover:border-indigo-300',
                'subtleBg' => 'bg-indigo-50',
                'textStrong' => 'text-indigo-900',
                'focusBorder' => 'focus:border-indigo-400',
                'focusRing' => 'focus:ring-indigo-100',
                'radioColor' => 'text-indigo-600',
                'radioRing' => 'focus:ring-indigo-500',
                'progress' => 'bg-indigo-500',
            ],
            'emerald' => [
                'bgSolid' => 'bg-emerald-600',
                'bgHover' => 'hover:bg-emerald-700',
                'borderSoft' => 'border-emerald-200',
                'borderHover' => 'hover:border-emerald-300',
                'subtleBg' => 'bg-emerald-50',
                'textStrong' => 'text-emerald-900',
                'focusBorder' => 'focus:border-emerald-400',
                'focusRing' => 'focus:ring-emerald-100',
                'radioColor' => 'text-emerald-600',
                'radioRing' => 'focus:ring-emerald-500',
                'progress' => 'bg-emerald-500',
            ],
            'sky' => [
                'bgSolid' => 'bg-sky-600',
                'bgHover' => 'hover:bg-sky-700',
                'borderSoft' => 'border-sky-200',
                'borderHover' => 'hover:border-sky-300',
                'subtleBg' => 'bg-sky-50',
                'textStrong' => 'text-sky-900',
                'focusBorder' => 'focus:border-sky-400',
                'focusRing' => 'focus:ring-sky-100',
                'radioColor' => 'text-sky-600',
                'radioRing' => 'focus:ring-sky-500',
                'progress' => 'bg-sky-500',
            ],
        ];
        $palette = $palettes[$accentKey] ?? $palettes['indigo'];
        config(['quiz.palette' => $palette]);
    @endphp
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-zinc-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
                <a href="{{ route('quizzes.index') }}" class="text-lg font-semibold tracking-tight text-zinc-900">
                    {{ config('app.name', 'Quiz Mastery') }}
                </a>
                <nav class="text-sm text-zinc-500">
                    <span class="font-medium text-zinc-700">Programming Quizzes</span>
                </nav>
            </div>
        </header>

        <main class="flex-1">
    <div class="mx-auto w-full max-w-6xl px-6 py-10">
        @if(session('status'))
            <div class="mb-6 rounded-lg border {{ config('quiz.palette.borderSoft', 'border-indigo-200') }} {{ config('quiz.palette.subtleBg', 'bg-indigo-50') }} px-4 py-3 text-sm {{ config('quiz.palette.textStrong', 'text-indigo-900') }}">
                {{ session('status') }}
            </div>
        @endif

        {{ $slot }}
    </div>
</main>
    </div>
</body>

</html>


