<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\ValueObject\Price;

/**
 * Class AdvertPriceParser
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
readonly class AdvertPriceParser
{
    /**
     * @param AdvertPriceCurrencyMatcher $currencyMatcher
     */
    public function __construct(
        private AdvertPriceCurrencyMatcher $currencyMatcher
    ) {
    }

    /**
     * @param string $priceText
     * @return Price
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public function parse(string $priceText): Price
    {
        $priceAmountText = preg_replace("/\D*/", '', $priceText);
        $priceCurrency = $this->currencyMatcher->getCurrency($priceText);

        return new Price(
            amount: $priceAmountText,
            currency: $priceCurrency->name
        );
    }
}
