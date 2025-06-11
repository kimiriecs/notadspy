<?php declare(strict_types=1);

namespace Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidCurrencyFormatException;
use App\Modules\AdSpy\Enum\CurrencySymbol;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertPriceCurrencyMatcher;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class AdvertPriceCurrencyMatcherTest
 *
 * @package Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertPriceCurrencyMatcherTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            [
                'priceText' => '100 грн.',
                'expectedCurrency' => CurrencySymbol::UAH
            ],
            [
                'priceText' => '100 ' . CurrencySymbol::USD->value,
                'expectedCurrency' => CurrencySymbol::USD
            ],
            [
                'priceText' => '100 ' . CurrencySymbol::EUR->value,
                'expectedCurrency' => CurrencySymbol::EUR
            ],
        ];
    }

    /**
     * @param string $priceText
     * @param CurrencySymbol $expectedCurrency
     * @return void
     * @throws InvalidCurrencyFormatException
     */
    #[DataProvider('dataProvider')]
    public function test_get_currency(string $priceText, CurrencySymbol $expectedCurrency)
    {
        $parser = new AdvertPriceCurrencyMatcher();
        $currency = $parser->getCurrency($priceText);

        $this->assertEquals($expectedCurrency, $currency);
        $this->assertEquals($expectedCurrency->value, $currency->value);
    }
}
