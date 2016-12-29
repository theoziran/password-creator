<?php
/**
 * Created by PhpStorm.
 * User: theoziran
 * Date: 12/29/16
 * Time: 12:51 PM
 */

namespace Puzzle\Rules;


interface RuleInterface
{
    public function apply($str);
}