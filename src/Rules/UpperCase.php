<?php
namespace Puzzle\Rules;

class UpperCase extends RuleAbstract
{

    public function apply($str)
    {
        $chars = str_split($str);
        $matches = $this->getLowerCaseIndex($chars);
        $count = ceil(count($matches) / 2);
        $size = ceil(($this->getComplexity() * $count) / 10);

        shuffle($matches);
        $matches = array_slice($matches, 0, $size);

        $chars = $this->upperCaseByIndex($matches, $chars);

        return implode('', $chars);
    }

    public function getLowerCaseIndex(array $chars)
    {
        $matches = [];
        foreach ($chars as $index => $char) {
            $isLowerCase = preg_match('/[a-z]/', $char);
            if ($isLowerCase) {
                $matches[] = $index;
            }
        }

        return $matches;
    }

    public function upperCaseByIndex(array $indexes, $chars){
        foreach ($indexes as $index) {
            $chars[$index] = strtoupper($chars[$index]);
        }

        return $chars;
    }
}
