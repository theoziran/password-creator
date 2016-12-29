<?php
namespace Puzzle\Exception;

class ConfigParserException extends \Exception
{
    public function __construct($item)
    {
        parent::__construct("The item '{$item}' is required in config file.");
    }
}
