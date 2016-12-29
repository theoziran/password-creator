<?php
namespace Puzzle\Rules;

use Puzzle\PasswordGenerator;

abstract class RuleAbstract implements RuleInterface
{
    private $complexity;
    private $config;

    public function __construct($config = [])
    {
        $this->config = $config;
        $this->complexity = $this->config[PasswordGenerator::CONFIG_COMPLEXITY];
    }

    public function getComplexity()
    {
        return $this->complexity;
    }

    public function setComplexity($complexity)
    {
        $this->complexity = $complexity;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }
}
