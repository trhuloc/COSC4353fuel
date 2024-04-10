<?php
use PHPUnit\Framework\TestCase;

class dbTest extends TestCase
{
    public function testDbConnection()
    {
        // Include db.php to trigger the connection attempt
        ob_start();
        include "db.php";
        $output = ob_get_clean();

        // Check if the output contains any connection error message
        $this->assertStringNotContainsString("Connection error:", $output);
    }
}
?>
