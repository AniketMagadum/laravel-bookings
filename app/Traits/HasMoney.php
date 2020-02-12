<?php

namespace App\Traits;

use Money\Currencies\ISOCurrencies;
use Money\Currencies\BitcoinCurrencies;
use Money\Currencies\AggregateCurrencies;
use Money\Currency;


trait HasMoney
{
    private function minorUnit($currency)
    {
        return 10 ** $this->subUnits($currency);
    }

    private function subUnits(string $currency)
    {
        return (new AggregateCurrencies([
            new ISOCurrencies(),
            new BitcoinCurrencies(),
        ]))->subunitFor(new Currency($currency));
    }
}
