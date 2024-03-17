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
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Please enter both username and password.", $output);
    }

    public function testInvalidCredentials()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'wrongpassword';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("Invalid username or password.", $output,  "testString doesn't contains 'geeks' as substring");
    }

//     public function testSuccessfulLogin()
//     {
//         $_SERVER['REQUEST_METHOD'] = 'POST';
//         $_POST['username'] = 'admin';
//         $_POST['password'] = 'password';

//         ob_start();
//         include 'login.php';
//         $output = ob_get_clean();

//         $expected = "Login successful!";
//         $this->assertStringContainsString($expected, $output,  $output) ;
//     }
    }
?>