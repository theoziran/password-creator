<?php
namespace Puzzle\Rules;

class SpecialChar extends RuleAbstract
{
    const CONFIG_MAP = 'map';

    public function apply($str)
    {
        $chars = str_split($str);
        $matches = $this->getLowerCasesMapped($chars);

        $size = ceil(($this->getComplexity() * count($matches)) / 10);

        $matches = array_splice($matches, 0, $size);

        $chars = $this->replaceByMap($matches, $chars);

        return implode('', $chars);
    }

    public function replaceByMap(array $matches, array $chars)
    {
        foreach ($matches as $index) {
            $replace = $this->getConfig()[self::CONFIG_MAP][$chars[$index]];
            if (is_array($replace)) {
                $replace = $replace[rand(0, count($replace) - 1)];
            }
            $chars[$index] = $replace;
        }

        return $chars;
    }

    public function getLowerCasesMapped(array $chars)
    {
        foreach ($chars as $index => $char) {
            if (preg_match('/[a-z]/', $char)
                && array_key_exists($char, $this->getConfig()[self::CONFIG_MAP])
            ) {
                $matches[] = $index;
            }
        }
        shuffle($matches);

        return $matches;
    }
}
