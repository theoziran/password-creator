<?php
namespace Puzzle\Rules;

class Compliance extends RuleAbstract
{
    const CONFIG_SPECIAL_CHARS = 'specialCharacter';

    public function apply($str)
    {
        $specialCharacter = str_split($this->getConfig()['specialCharacter']);

        if (!preg_match('/\d/', $str)) {
            $str .= rand(0,9);
        }

        $specialChars = preg_replace('/[+0-9+A-Z+a-z]/', '', $str);
        if (empty($specialChars)) {
            $str .= $specialCharacter[rand(0,count($specialCharacter))];
        }

        return $str;

    }

}
