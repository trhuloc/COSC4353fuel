<?php
use PHPUnit\Framework\TestCase;

require_once "Pricing.php";
class quoteTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testEmptyFields()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["gallonsRequested"] = "";
        $_POST["deliveryDate"] = "";

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();

        $expected = "Please fill out the required information.";
        $this->assertStringContainsString($expected, $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testInvalidGallonsRequested()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["gallonsRequested"] = "abc";
        $_POST["deliveryDate"] = "2024-10-01";

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();

        $expected = "Gallons Requested must be a numeric value.";
        $this->assertStringContainsString($expected, $output);
    }
    /**
     * @runInSeparateProcess
     */
    public function testCalculateTotalPrice()
    {
        $pricingModule = new PricingModule(1.5);
        $totalPrice = $pricingModule->calculateTotalPrice(1500,'TX',1);
        $output = 2542.5;
        $this->assertEquals($output, $totalPrice);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCalculateTotalPriceWithDifferentLocation()
    {
        $pricingModule = new PricingModule(1.5);
        $totalPrice = $pricingModule->calculateTotalPrice(1000,'NY',1);
        $output = 1740.0;
        $this->assertEquals($output, $totalPrice);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCalculateTotalPriceWithNoRateHistory()
    {
        $pricingModule = new PricingModule(1.5);
        $totalPrice = $pricingModule->calculateTotalPrice(800,'TX',0);
        $output = 1380.0;
        $this->assertEquals($output, $totalPrice);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCalculateTotalPriceWithLowGallonsRequested()
    {
        $pricingModule = new PricingModule(1.5);
        $totalPrice = $pricingModule->calculateTotalPrice(500,'TX',1);
        $output = 855.0;
        $this->assertEquals($output, $totalPrice);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCalculateTotalPriceWithHighGallonsRequested()
    {
        $pricingModule = new PricingModule(1.5);
        $totalPrice = $pricingModule->calculateTotalPrice(1200,'TX',1);
        $output = 2034.0;
        $this->assertEquals($output, $totalPrice);
    }

}
