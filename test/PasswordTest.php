<?php
use PHPUnit\Framework\TestCase;
use Puzzle\PasswordGenerator;

class PasswordTest extends TestCase
{
    const PASSWORD_LENGTH_CONSTRAINT = 6;

    private $passwordGenerator;

    public function testValidPassword()
    {
        $this->passwordGenerator = new PasswordGenerator(require_once 'config.php');
        $password = $this->passwordGenerator->getPassword();

        print_r("\n" . $password);

        $this->assertTrue(strlen($password) >= self::PASSWORD_LENGTH_CONSTRAINT,
            'A minimum length required is ' . self::PASSWORD_LENGTH_CONSTRAINT);
        $this->assertRegExp('/[A-Z]/', $password, 'At least one uppercase letter is required');
        $this->assertRegExp('/[a-z]/', $password, 'At least one lowercase letter is required');
        $this->assertRegExp('/\d/', $password, 'At least one decimal character is required');
        $this->assertNotEmpty(preg_replace('/[+0-9+A-Z+a-z]/', '', $password), 'At least one special character is required');
    }
}
