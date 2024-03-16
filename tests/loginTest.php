<?php
use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
    public function testEmptyFields()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = '';
        $_POST['password'] = '';

        ob_start();
        include 'process_login.php';
        $output = ob_get_clean();

        $this->assertEquals("Please enter both username and password.", $output);
    }

    public function testInvalidCredentials()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'wrongpassword';

        ob_start();
        include 'process_login.php';
        $output = ob_get_clean();

        $this->assertEquals("Invalid username or password.", $output);
    }

    public function testSuccessfulLogin()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'password';

        ob_start();
        include 'process_login.php';
        $output = ob_get_clean();

        $this->assertEquals("Login successful!", $output);
    }
}
?>