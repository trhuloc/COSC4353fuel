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
    public function testEmptyUsername()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["username"] = "";
        $_POST["password"] = "password123";

        ob_start();
        include "login.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Please enter both username and password.", $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testEmptyPassword()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["username"] = "john";
        $_POST["password"] = "";

        ob_start();
        include "login.php";
        $output = ob_get_clean();

        $this->assertStringContainsString("Please enter both username and password.", $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testInvalidCredentials()
    {
        include "db.php";
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
    public function testVerifyPassword()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'trhuloc@gmail.com';
        $_POST['password'] = '12345678';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Password is correct.", $output);
    }
}
?>