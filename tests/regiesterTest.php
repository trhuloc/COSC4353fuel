<?php
use PHPUnit\Framework\TestCase;

class regiesterTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testRegistrationSuccess()
    {
        $_POST["username"] = "john";
        $_POST["password"] = "password123";

        ob_start();
        include "register.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Registration successful!", $output);
    }

    public function testRegistrationFailure()
    {
        $_POST["username"] = "";
        $_POST["password"] = "password123";

        ob_start();
        include "register.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Please fill in all the fields.", $output);
    }

    public function testPasswordLength()
    {
        $_POST["username"] = "john";
        $_POST["password"] = "pass";

        ob_start();
        include "register.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Password must be at least 8 characters long.", $output);
    }

}
?>