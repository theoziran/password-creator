<?php
namespace Puzzle\Rules;

abstract class RuleAbstract
{

    const CONFIG_COMPLEXITY = 'complexity';
    const DEFAUT_COMPLEXITY = 1;

    private $_complexity;
    private $_config;

    public function __construct($config = [])
    {
        $this->_config = $config;
        $this->_complexity = self::DEFAUT_COMPLEXITY;
        if (!array_key_exists(self::CONFIG_COMPLEXITY,  $this->_config)) {
            $this->_complexity = $this->_config[self::CONFIG_COMPLEXITY];
        }
    }

    public function getComplexity()
    {
        return $this->_complexity;
    }

    public function setComplexity($complexity)
    {
        if($complexity < 0 || $complexity > 10){
            throw new \Exception("Complexity has to be between 1 and 10");
        }

        $this->_complexity = $complexity;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function setConfig($config)
    {
        $this->_config = $config;
    }

    public abstract function apply($str);
}