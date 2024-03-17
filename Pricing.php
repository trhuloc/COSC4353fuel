<?php
class PricingModule {
    private $pricePerGallon;

    public function __construct($pricePerGallon) {
        $this->pricePerGallon = $pricePerGallon;
    }

    public function calculateTotalPrice($gallonsRequested) {
        return $gallonsRequested * $this->pricePerGallon;
    }
}
?>