<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Quiz Display Mode
    |--------------------------------------------------------------------------
    |
    | Supported: "all", "single"
    | - "all": show every question at once.
    | - "single": show one question at a time with progress controls.
    |
    */
    'display_mode' => env('QUIZ_DISPLAY_MODE', 'all'),

    /*
    |--------------------------------------------------------------------------
    | Accent Color
    |--------------------------------------------------------------------------
    |
    | Tailwind color keyword used across quiz UI elements. Keep this in sync
    | with your design tokens when adding theming or admin customization later.
    |
    */
    'accent_color' => 'indigo',
];


