<?php declare(strict_types=1);

namespace Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Enum\CurrencySymbol;
use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Enum\TimeZone;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertPageParser;
use App\ValueObject\ImageUrl;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class AdvertDataFetcherTest
 *
 * @package Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertDataFetcherTest extends TestCase
{
    /**
     * @return array[]
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     * @throws \DateInvalidTimeZoneException
     * @throws \DateMalformedStringException
     */
    public static function dataProvider(): array
    {
        return [
            [
                'url' => Url::make('https://some.url'),
                'response' => "<!doctype html><html lang=en><meta charset=UTF-8><title>Title</title><div data-testid=ad-photo><div><img src=https://image.url></div></div><div data-testid=offer_title><h4>title</h4></div><span data-testid=ad-posted-at>Сьогодні о 10:16</span><div data-testid=ad-price-container><h3>69 500 $</h3></div></html>",
                'locale' => Locale::UA,
                'expectedData' => new AdvertData(
                    title: Title::make('title'),
                    url: Url::make('https://some.url'),
                    imageUrl: ImageUrl::make('https://image.url'),
                    postedAt: new DateTimeImmutable('now', new DateTimeZone(TimeZone::KYIV->value))->setTime(13,16),// 10:16 - in response fetched in GMT, 13:16 - on page displayed in Europe/Kyiv
                    price: new PriceData(new Price(amount: 69500, currency: CurrencySymbol::USD->name))
                )
            ],
            [
                'url' => Url::make('https://some.url'),
                'response' => "<!doctype html><html lang=en><meta charset=UTF-8><title>Title</title><div data-testid=ad-photo><div><img src=https://image.url></div></div><div data-testid=offer_title><h4>title</h4></div><span data-testid=ad-posted-at>09 червня 2025р.</span><div data-testid=ad-price-container><h3>69 500 $</h3></div></html>",
                'locale' => Locale::UA,
                'expectedData' => new AdvertData(
                    title: Title::make('title'),
                    url: Url::make('https://some.url'),
                    imageUrl: ImageUrl::make('https://image.url'),
                    postedAt: new DateTimeImmutable('2025-06-09', new DateTimeZone(TimeZone::KYIV->value))->setTime(0,0),
                    price: new PriceData(new Price(amount: 69500, currency: CurrencySymbol::USD->name))
                )
            ]
        ];
    }

    /**
     * @param Url $url
     * @param string $response
     * @param Locale $locale
     * @param AdvertData $expectedData
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     */
    #[DataProvider('dataProvider')]
    public function test_fetch(
        Url $url,
        string $response,
        Locale $locale,
        AdvertData $expectedData,
    ): void {
        $parser = $this->app->make(AdvertPageParser::class);
        $parsedData = $parser->parse($url, $response, $locale);

        $this->assertEquals($expectedData, $parsedData);
        $this->assertEquals($expectedData->getUrl(), $parsedData->getUrl());
        $this->assertEquals($expectedData->getTitle(), $parsedData->getTitle());
        $this->assertEquals($expectedData->getImageUrl(), $parsedData->getImageUrl());
        $this->assertEquals($expectedData->getPostedAt(), $parsedData->getPostedAt());
        $this->assertEquals($expectedData->getPrice(), $parsedData->getPrice());
    }
}
