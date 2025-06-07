<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidCurrencyFormatException;
use App\Modules\AdSpy\Enum\CurrencySymbol;

/**
 * Class AdvertPriceCurrencyMatcher
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertPriceCurrencyMatcher
{
    /**
     * @param string $priceText
     * @return CurrencySymbol
     * @throws InvalidCurrencyFormatException
     */
    public function getCurrency(string $priceText): CurrencySymbol
    {
        $currencySymbol = trim(preg_replace("/[\d\s]*/", '', $priceText));
        $isLocaleCurrency = !in_array($currencySymbol, CurrencySymbol::foreign());
        if ($isLocaleCurrency) {
            return CurrencySymbol::UAH;
        }

        $currency = CurrencySymbol::tryFrom($currencySymbol);
        if (!$currency instanceof CurrencySymbol) {
            throw new InvalidCurrencyFormatException('Unable to detect advert price currency');
        }

        return $currency;
    }
}
