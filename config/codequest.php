<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    |
    | Languages offered to learners, in display order. A language only shows
    | up when content/<key>/ has at least one level. `file` is the example
    | file name shown above code samples; its extension is the language badge.
    |
    */

    'languages' => [
        'python' => [
            'name' => 'Python',
            'file' => 'main.py',
            'tagline' => 'Sintaksnya ringkas dan mudah dibaca, cocok untuk langkah pertama. Banyak dipakai untuk data, otomasi, dan AI.',
        ],
        'java' => [
            'name' => 'Java',
            'file' => 'Main.java',
            'tagline' => 'Banyak diajarkan di kampus dan dipakai untuk aplikasi Android serta sistem perusahaan.',
        ],
        'c' => [
            'name' => 'C',
            'file' => 'main.c',
            'tagline' => 'Kenali cara kerja komputer dari dekat. Banyak bahasa modern meminjam sintaksnya dari C.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Homepage
    |--------------------------------------------------------------------------
    |
    | `demo_question` is the id of the question visitors can try on the
    | homepage without an account. Any question id from content/ works.
    |
    */

    'home' => [
        'demo_question' => 'python-l1-q06',
    ],

];
