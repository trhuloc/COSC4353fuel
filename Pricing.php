<?php
class PricingModule {
    private $pricePerGallon;

    public function __construct($pricePerGallon) {
        $this->pricePerGallon = $pricePerGallon;
    }

    public function calculateTotalPrice($gallonsRequested, $location, $hasHistory) {
        $currentPrice = 1.50;
        $locationFactor = ($location == 'TX') ? 0.02 : 0.04;
        $rateHistoryFactor = ($hasHistory) ? 0.01 : 0;
        $gallonsRequestedFactor = ($gallonsRequested > 1000) ? 0.02 : 0.03;
        $companyProfitFactor = 0.1;

        $margin = ($locationFactor - $rateHistoryFactor + $gallonsRequestedFactor + $companyProfitFactor) * $currentPrice;
        $suggestedPrice = $currentPrice + $margin;
        $totalAmountDue = $gallonsRequested * $suggestedPrice;

        return $totalAmountDue;
    }
}
?>