<?php

class Pricing {
    // Properties
    private $basePricePerGallon;

    // Constructor
    public function __construct($basePricePerGallon) {
        $this->basePricePerGallon = $basePricePerGallon;
    }

    // Method to calculate total amount due based on gallons requested
    public function calculateTotalAmountDue($gallonsRequested) {
        return $gallonsRequested * $this->basePricePerGallon;
    }

    // Getter method for base price per gallon
    public function getBasePricePerGallon() {
        return $this->basePricePerGallon;
    }

    // Setter method for base price per gallon
    public function setBasePricePerGallon($basePricePerGallon) {
        $this->basePricePerGallon = $basePricePerGallon;
    }
}

// Example usage:
$pricing = new Pricing(2.3); // Initialize with base price per gallon
$gallonsRequested = 100; // Example value
$totalAmountDue = $pricing->calculateTotalAmountDue($gallonsRequested);
echo "Total amount due: $" . number_format($totalAmountDue, 2); // Example output

?>
