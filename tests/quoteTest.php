<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
require_once "Pricing.php";
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
    public function testCalculateTotalPrice()
    {
        $pricingModule = new PricingModule(2.3);
        $totalPrice = $pricingModule->calculateTotalPrice(1000);
        $this->assertEquals(2300, $totalPrice);
    }
}
?>