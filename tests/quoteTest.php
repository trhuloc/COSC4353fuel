<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
class quoteTest extends TestCase
{

    public function testInvalidGallonsRequested()
    {
        $_POST["gallonsRequested"] = "abc";
        $_POST["deliveryDate"] = "2022-10-01";

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();
        $expected = "Gallons Requested must be a numeric value.";
        $this->assertStringContainsString($expected, $output) ;
    }
}
?>