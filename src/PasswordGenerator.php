<?php
namespace Puzzle;

class PasswordGenerator
{
    private $complexity = 1;

    private $strength = 1;

    private $map;

    private $specialCharacters;

    /** @var array */
    private $words;

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
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * @param mixed $complexity
     */
    public function setComplexity($complexity)
    {
        $this->complexity = $complexity;
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

    /**
     * @return mixed
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param mixed $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }

    /**
     * @return mixed
     */
    public function getSpecialCharacters()
    {
        return $this->specialCharacters;
    }

    /**
     * @param mixed $specialCharacters
     */
    public function setSpecialCharacters($specialCharacters)
    {
        if(is_string($specialCharacters)){
            $specialCharacters = str_split($specialCharacters);
        }
        $this->specialCharacters = $specialCharacters;
    }


    public function getPassword()
    {
        shuffle($this->words);

        $countWords = count($this->words);
        if($countWords  > 5) $countWords = 5;

        $numberOfWords = ceil(($this->getStrength() * $countWords) / 10);
        $words = array_slice($this->words, 0, $numberOfWords);

        while(strlen(implode('', $words)) < 6){
            $numberOfWords++;
            $words = array_slice($this->words, 0, $numberOfWords);
        }

        $chars = str_split(implode('', $words));

        $countReplacebleChars = 0;

        $map = array_keys($this->getMap());

        $replaceable = [];

        foreach($chars as $char){
            if(in_array($char, $map)){
                $countReplacebleChars++;
                $replaceable[] = $char;
            }
        }

        shuffle($replaceable);

        $numberOfSpecialChar = ceil(($this->getComplexity() * $countReplacebleChars) / 10);
        $replaceableCharsBasedOnComplexity = array_slice($replaceable, 0, $numberOfSpecialChar);

        $lowerCaseReplaceable = [];

        foreach($chars as $index => $char){
            $key = array_search($char, $replaceableCharsBasedOnComplexity);
            if($key !== false){
                $chars[$index] = $this->getMap()[$char];
                unset($replaceableCharsBasedOnComplexity[$key]);
            }else if(preg_match('/[a-z]/', $char)){
                $lowerCaseReplaceable[] = $char;
            }
        }


        $countLowerCaseChars = count($lowerCaseReplaceable) - 1; // let at least one lower
        $numberOfLowerChar = ceil(($this->getComplexity() * $countLowerCaseChars) / 10);

        $lowerChars = array_filter($chars, function($char){
            return preg_match('/[a-z]/', $char);
        });

        shuffle($lowerChars);

        $lowCharsMap = [];
        foreach($lowerChars as $lowChar){
            if($numberOfLowerChar > 0){
                $lowCharsMap[$lowChar] = strtoupper($lowChar);
                $numberOfLowerChar--;
            }
        }

        foreach($lowCharsMap as $lowChar => $upperChar){
            $key = array_search($lowChar, $chars);
            if($key !== false && array_key_exists($lowChar, $lowCharsMap) !== false){
                $chars[$key] = $upperChar;
                unset($lowCharsMap[$lowChar]);
            }
        }

        $password = implode('', $chars);

        $password = $this->normatize($password);


        return $password;

    }

    private function hasDecimal( $password ){
        return preg_match('/\d/', $password);
    }

    private function normatize($password){
        if(!$this->hasDecimal($password)){
            $password .= rand(0,9);
        }

        return $password;
    }
}

