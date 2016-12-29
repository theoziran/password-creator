<?php
namespace Puzzle\Rules;

class SpecialChar extends RuleAbstract
{
    const CONFIG_MAP = 'map';

    public function apply($str)
    {
        $config = $this->getConfig();
        $map = [];
        if (array_key_exists(self::CONFIG_MAP, $config)) {
            $map = $config['map'];
        }

        $chars = str_split($str);
        $matches = [];

        foreach ($chars as $index => $char) {
            if (preg_match('/[a-z]/', $char) && array_key_exists($char, $map)) {
                $matches[] = $index;
            }
        }
        shuffle($matches);

        $size = ceil(($this->getComplexity() * count($matches)) / 10);
        $matches = array_splice($matches, 0, $size);

        foreach ($matches as $index) {
            $replace = $map[$chars[$index]];
            if (is_array($replace)) {
                $replace = $replace[rand(0, count($replace) - 1)];
            }
            $chars[$index] = $replace;
        }

        return implode('', $chars);
    }
}
