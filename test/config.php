<?php
return [
    'strength' => 1,
    'complexity' => 1,
    'specialCharacter' => '~!@#$%^&*_-+=`|(){}[]:;"\'<>,.?/',
    'map' => [
        'a' => ['@','4'],
        'b' => '|3',
        'e' => '3',
        'f' => '|=',
        'h' => '|-|',
        'i' => '!',
        'k' => '|<',
        'l' => '1',
        'o' => '0',
        's' => ['$', '5']
    ],
    'words' => ['lamma', 'ace', 'dig', 'eleven', 'book'],
    'max_words' => 5,
    'rules' => [
        'Puzzle\Rules\UpperCase',
        'Puzzle\Rules\SpecialChar',
        'Puzzle\Rules\Compliance',
    ]
];
