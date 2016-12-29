<?php
namespace Puzzle;

use Puzzle\Rules\RuleAbstract;

class PasswordGenerator
{

    const CONFIG_MAX_WORDS = 'max_words';
    const CONFIG_RULES = 'rules';
    const CONFIG_STRENGTH = 'strength';
    const CONFIG_WORDS = 'words';
    const CONFIG_SPECIAL_CHARS = 'specialCharacter';

    private $_strength;

    private $_rules = [];

    private $_words;

    private $_config = [];

    public function __construct($config)
    {
        $this->_verifyRequiredConfig($config);
        $this->_init($config);
    }

    /**
     * @return array
     */
    public function getWords()
    {
        return $this->_words;
    }

    /**
     * @param array $words
     */
    public function setWords($words)
    {
        $this->_words = $words;
    }

    /**
     * @return mixed
     */
    public function getStrength()
    {
        return $this->_strength;
    }

    /**
     * @param mixed $strength
     */
    public function setStrength($strength)
    {
        $this->_strength = $strength;
    }


    public function getPassword()
    {
        shuffle($this->_words);
        $words = array_slice(
            $this->_words, 0,
            $this->_config[self::CONFIG_MAX_WORDS]
        );
        $size = ceil(($this->getStrength() * count($words)) / 10);
        if ($size == 1) $size++;

        $selectedWords = implode('', array_slice($words, 0, $size));

        foreach($this->_rules as $rule){
            $selectedWords = $rule->apply($selectedWords);
        }

        return $selectedWords;
    }

    public function addRule(RuleAbstract $rule)
    {
        $this->_rules[] = $rule;
    }

    public function clearRules()
    {
        $this->_rules = [];
    }

    private function _init($config)
    {
        $this->_config = $config;
        foreach ($config[self::CONFIG_RULES] as $rule) {
            $this->_rules[] = new $rule($this->_config);
        }
        $this->_words = $config[self::CONFIG_WORDS];
        $this->_strength = $config[self::CONFIG_STRENGTH];
    }

    private function _verifyRequiredConfig(array $config)
    {
        $configItems = [self::CONFIG_RULES,self::CONFIG_MAX_WORDS,
            self::CONFIG_STRENGTH,self::CONFIG_WORDS,self::CONFIG_SPECIAL_CHARS];
        foreach ($configItems as $item) {

            if (!array_key_exists($item, $config)) {
                throw new \Exception("The item '{$item}' is required in config file.");
            }

        }
    }
}

