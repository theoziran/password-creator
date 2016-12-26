<?php
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    const PASSWORD_LENGTH_CONSTRAINT = 6;

    public function testValidPassword()
    {

        $passwordGenerator = new PasswordGenerator();
        $password = $passwordGenerator->getPassword();

        $this->assertTrue(strlen($password) >= self::PASSWORD_LENGTH_CONSTRAINT );
        $this->assertStringMatchesFormat('/[A-Z]/', $password);
        $this->assertStringMatchesFormat('/[a-z]/', $password);
        $this->assertStringMatchesFormat('/\d/', $password);
    }
}
