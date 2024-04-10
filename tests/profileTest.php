<?php
use PHPUnit\Framework\TestCase;

class profileTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testFullNameIsRequired()
    {   
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = '';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Full Name is required.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testFullNameShouldNotExceed50Characters()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod.';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Full Name should not exceed 50 characters.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testAddress1IsRequired()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Address 1 is required.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testAddress1ShouldNotExceed100Characters()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = str_repeat('a', 101);
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Address 1 should not exceed 100 characters.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testAddress2ShouldNotExceed100Characters()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = str_repeat('a', 101);
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Address 2 should not exceed 100 characters.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testCityIsRequired()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = '';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('City is required.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testCityShouldNotExceed100Characters()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = str_repeat('a', 101);
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('City should not exceed 100 characters.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testStateIsRequired()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = '';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('State is required.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testStateShouldHaveValidFormat()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'ABC';
        $_POST['zipcode'] = '12345';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid State format.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testZipcodeIsRequired()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Zipcode is required.', $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testZipcodeShouldHaveValidFormat()
    {
        include "db.php";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['fullName'] = 'John Doe';
        $_POST['address1'] = '123 Main St';
        $_POST['address2'] = '';
        $_POST['city'] = 'New York';
        $_POST['state'] = 'NY';
        $_POST['zipcode'] = '123';

        ob_start();
        include 'profile_management.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid Zipcode format.', $output);
    }
}
?>
