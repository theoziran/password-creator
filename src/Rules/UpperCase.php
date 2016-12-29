<?php
namespace Puzzle\Rules;

class UpperCase extends RuleAbstract
{

    public function apply($str)
    {
        $matches = [];
        $chars = str_split($str);
        foreach ($chars as $index => $char) {
            $isLowerCase = preg_match('/[a-z]/', $char);
            if ($isLowerCase) {
                    $matches[] = $index;
            }
        }

        $count = ceil(count($matches) / 2);
        $size = ceil(($this->getComplexity() * $count) / 10);

        shuffle($matches);
        $matches = array_slice($matches, 0, $size);

        foreach ($matches as $index) {
            $chars[$index] = strtoupper($chars[$index]);
        }

        return implode('', $chars);

    }
}
