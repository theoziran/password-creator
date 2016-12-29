<?php
/**
 * Created by PhpStorm.
 * User: theoziran
 * Date: 12/29/16
 * Time: 12:40 PM
 */

namespace Puzzle\Exception;


class ConfigComplexityOutOfBound extends \Exception
{
    public function __construct()
    {
        parent::__construct('The range has to be between 1 and 10');
    }
}