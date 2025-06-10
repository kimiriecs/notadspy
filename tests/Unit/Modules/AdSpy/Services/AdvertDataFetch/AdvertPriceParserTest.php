<?php declare(strict_types=1);

namespace Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Enum\CurrencySymbol;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertPriceParser;
use App\ValueObject\Price;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class AdvertPriceParserTest
 *
 * @package Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertPriceParserTest extends TestCase
{
    /**
     * @throws InvalidNumberFormatException
     * @throws InvalidCurrencyFormatException
     */
    public static function dataProvider(): array
    {
        return [
            [
                'priceString' => '100 грн.',
                'expectedPrice' => new Price(
                    amount: 100,
                    currency: CurrencySymbol::UAH->name
                )
            ]
        ];
    }

    /**
     * @return void
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws BindingResolutionException
     */
    #[DataProvider('dataProvider')]
    public function test_parse(string $priceString, Price $expectedPrice)
    {
        $parser = $this->app->make(AdvertPriceParser::class);
        $parsedPrice = $parser->parse($priceString);

        $this->assertEquals($expectedPrice->amount(), $parsedPrice->amount());
        $this->assertEquals($expectedPrice->amount()->asInt(), $parsedPrice->amount()->asInt());
        $this->assertEquals($expectedPrice->currency(), $parsedPrice->currency());
        $this->assertEquals($expectedPrice->currency()->value(), $parsedPrice->currency()->value());
    }
}
