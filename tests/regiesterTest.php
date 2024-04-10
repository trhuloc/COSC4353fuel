<?php
use PHPUnit\Framework\TestCase;

class regiesterTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testRegistrationFailure()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["username"] = "";
        $_POST["password"] = "password123";

        ob_start();
        include "register.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Please fill in all the fields.", $output);
    }

    public function testPasswordLength()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["username"] = "john";
        $_POST["password"] = "pass";

        ob_start();
        include "register.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Password must be at least 8 characters long.", $output);
    }

}
?>