<?php
use PHPUnit\Framework\TestCase;

require_once "Pricing.php";

class quoteTest extends TestCase
{
    public function testEmptyForm()
    {
        $_SERVER["REQUEST_METHOD"] = "GET";

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();

        $expected = "Please fill out the form.";
        $this->assertStringContainsString($expected, $output);
    }

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

    public function testInvalidGallonsRequestedNegativeNumber()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["gallonsRequested"] = "-1";
        $_POST["deliveryDate"] = "2024-10-01";

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();

        $expected = "Gallons Requested must be larger than 0.";
        $this->assertStringContainsString($expected, $output);
    }

    public function testInvalidDeliveryDate()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["gallonsRequested"] = "5";
        $_POST["deliveryDate"] = "2022-10-01";

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();

        $expected = "Delivery Date must be valid.";
        $this->assertStringContainsString($expected, $output);
    }

    public function testCalculateTotalPrice()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST["gallonsRequested"] = "1000";
        $_POST["deliveryDate"] = "2024-10-01";

        $pricingModule = new PricingModule(2.3);
        $totalPrice = $pricingModule->calculateTotalPrice(1000);

        ob_start();
        include "submit_quote.php";
        $output = ob_get_clean();

        $expected = "<h1>Total Amount Due: $totalPrice</h1>";
        $this->assertStringContainsString($expected, $output);
    }
}
