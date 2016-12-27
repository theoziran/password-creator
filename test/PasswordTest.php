<?php
use PHPUnit\Framework\TestCase;
use Puzzle\PasswordGenerator;

class PasswordTest extends TestCase
{
    const PASSWORD_LENGTH_CONSTRAINT = 6;

    private $passwordGenerator;

    public function setUp(){

        $this->passwordGenerator = new PasswordGenerator();
        $this->passwordGenerator->setSpecialCharacters('~!@#$%^&*_-+=`|(){}[]:;"\'<>,.?/');
        $this->passwordGenerator->setWords(['lamma', 'ace', 'dig', 'eleven', 'book']);
        $this->passwordGenerator->setMap([
            'a' => '@',
            'b' => '|3',
            'e' => '3',
            'f' => '|=',
            'h' => '|-|',
            'i' => '!',
            'k' => '|<',
            'l' => '1',
            'o' => '0',
            's' => '$'
        ]);
    }

    public function testValidPassword()
    {
        $password = $this->passwordGenerator->getPassword();
        $this->assertTrue(strlen($password) >= self::PASSWORD_LENGTH_CONSTRAINT,
            'A minimum length required is ' . self::PASSWORD_LENGTH_CONSTRAINT);
        $this->assertRegExp('/[A-Z]/', $password, 'At least one uppercase letter is required');
        $this->assertRegExp('/[a-z]/', $password, 'At least one lowercase letter is required');
        $this->assertRegExp('/\d/', $password, 'At least one decimal character is required');
    }
}
