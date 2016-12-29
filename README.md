# PHP Password Creator [![Build Status](https://travis-ci.org/theoziran/password-creator.svg?branch=master)](https://travis-ci.org/theoziran/password-creator)

## Getting started

```php
<?php
$config = [
    'strength' => 10,
    'complexity' => 10,
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


$this->passwordGenerator = new PasswordGenerator($config);
$password = $this->passwordGenerator->getPassword();


```
