<?php
namespace Puzzle;

use Puzzle\Exception\ConfigParserException;
use Puzzle\Exception\ConfigComplexityOutOfBound;
use Puzzle\Rules\RuleInterface;

class PasswordGenerator
{

    const CONFIG_MAX_WORDS = 'max_words';
    const CONFIG_RULES = 'rules';
    const CONFIG_STRENGTH = 'strength';
    const CONFIG_WORDS = 'words';
    const CONFIG_SPECIAL_CHARS = 'specialCharacter';
    const CONFIG_COMPLEXITY = 'complexity';

    private $strength;

    private $rules = [];

    private $words = [];

    private $config = [];

    public function __construct($config)
    {
        $this->verifyRequiredConfig($config);
        $this->init($config);
    }

    /**
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param array $words
     */
    public function setWords($words)
    {
        $this->words = $words;
    }

    /**
     * @return mixed
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @param mixed $strength
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
    }

    public function getPassword()
    {
        shuffle($this->words);
        $words = array_slice(
            $this->words,
            0,
            $this->config[self::CONFIG_MAX_WORDS]
        );
        $size = ceil(($this->getStrength() * count($words)) / 10);
        if ($size == 1) $size++;

        $selectedWords = implode('', array_slice($words, 0, $size));

        foreach ($this->rules as $rule) {
            $selectedWords = $rule->apply($selectedWords);
        }

        return $selectedWords;
    }

    public function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    public function clearRules()
    {
        $this->rules = [];
    }

    private function init($config)
    {
        $this->config = $config;
        foreach ($config[self::CONFIG_RULES] as $rule) {
            $this->rules[] = new $rule($this->config);
        }
        $this->words = $config[self::CONFIG_WORDS];
        $this->strength = $config[self::CONFIG_STRENGTH];
    }

    private function verifyRequiredConfig(array $config)
    {
        $configItems = [self::CONFIG_RULES,self::CONFIG_MAX_WORDS,
            self::CONFIG_STRENGTH,self::CONFIG_WORDS,
            self::CONFIG_SPECIAL_CHARS,self::CONFIG_COMPLEXITY];

        foreach ($configItems as $item) {
            if (!array_key_exists($item, $config)) {
                throw new ConfigParserException($item);
            }
        }

        if (!in_array($config[self::CONFIG_COMPLEXITY], range(1, 10))
            || !in_array($config[self::CONFIG_STRENGTH], range(1, 10))
        ) {
            throw new ConfigComplexityOutOfBound;
        }
    }
}
