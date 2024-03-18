<?php
use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testEmptyFields()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = '';
        $_POST['password'] = '';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Please enter both username and password.", $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidCredentials()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'wrongpassword';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Invalid username or password.", $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSuccessfulLogin()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'password';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $expected = "Login successful!";
        $this->assertStringContainsString($expected, $output);
    }
}
?>