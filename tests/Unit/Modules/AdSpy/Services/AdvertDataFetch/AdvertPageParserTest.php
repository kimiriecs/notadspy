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
use App\Modules\AdSpy\Exception\AdvertClientException;
use App\Modules\AdSpy\Exception\AdvertParsingException;
use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\Modules\AdSpy\Interface\AdvertPageParserInterface;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertDataFetcher;
use App\ValueObject\ImageUrl;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

/**
 * Class AdvertPageParserTest
 *
 * @package Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertPageParserTest extends TestCase
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
                'response' => new Response("<!doctype html><html lang=en><meta charset=UTF-8><title>Title</title><div data-testid=ad-photo><div><img src=https://image.url></div></div><div data-testid=offer_title><h4>title</h4></div><span data-testid=ad-posted-at>Сьогодні о 10:16</span><div data-testid=ad-price-container><h3>69 500 $</h3></div></html>"),
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
                'response' => new Response("<!doctype html><html lang=en><meta charset=UTF-8><title>Title</title><div data-testid=ad-photo><div><img src=https://image.url></div></div><div data-testid=offer_title><h4>title</h4></div><span data-testid=ad-posted-at>09 червня 2025р.</span><div data-testid=ad-price-container><h3>69 500 $</h3></div></html>"),
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
     * @return array
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidUrlFormatException
     */
    public static function priceTestDataProvider(): array
    {
        return [
            [
                'url' => Url::make('https://some.url'),
                'response' => new Response("<!doctype html><html lang=en><meta charset=UTF-8><title>Title</title><div data-testid=ad-photo><div><img src=https://image.url></div></div><div data-testid=offer_title><h4>title</h4></div><span data-testid=ad-posted-at>Сьогодні о 10:16</span><div data-testid=ad-price-container><h3>69 500 $</h3></div></html>"),
                'expectedPrice' => new Price(amount: 69500, currency: CurrencySymbol::USD->name)
            ],
            [
                'url' => Url::make('https://some.url'),
                'response' => new Response("<!doctype html><html lang=en><meta charset=UTF-8><title>Title</title><div data-testid=ad-photo><div><img src=https://image.url></div></div><div data-testid=offer_title><h4>title</h4></div><span data-testid=ad-posted-at>09 червня 2025р.</span><div data-testid=ad-price-container><h3>69 500 $</h3></div></html>"),
                'expectedPrice' => new Price(amount: 69500, currency: CurrencySymbol::USD->name)
            ]
        ];
    }

    /**
     * @param Url $url
     * @param Response $response
     * @param AdvertData $expectedData
     * @return void
     * @throws BindingResolutionException
     * @throws AdvertClientException
     * @throws AdvertParsingException
     * @throws Exception
     */
    #[DataProvider('dataProvider')]
    public function test_fetch(
        Url $url,
        Response $response,
        AdvertData $expectedData,
    ): void {
        $httpClient = $this->createStub(AdvertClientInterface::class);
        $httpClient->method('get')->willReturn($response);

        $parser = $this->app->make(AdvertPageParserInterface::class);

        $fetcher = new AdvertDataFetcher($httpClient, $parser);
        $fetchedData = $fetcher->fetch($url);

        $this->assertEquals($expectedData, $fetchedData);
        $this->assertEquals($expectedData->getUrl(), $fetchedData->getUrl());
        $this->assertEquals($expectedData->getTitle(), $fetchedData->getTitle());
        $this->assertEquals($expectedData->getImageUrl(), $fetchedData->getImageUrl());
        $this->assertEquals($expectedData->getPostedAt(), $fetchedData->getPostedAt());
        $this->assertEquals($expectedData->getPrice(), $fetchedData->getPrice());
    }

    /**
     * @param Url $url
     * @param Response $response
     * @param Price $expectedPrice
     * @return void
     * @throws AdvertClientException
     * @throws AdvertParsingException
     * @throws BindingResolutionException
     * @throws Exception
     */
    #[DataProvider('priceTestDataProvider')]
    public function test_fetch_price(
        Url $url,
        Response $response,
        Price $expectedPrice,
    ): void {
        $httpClient = $this->createStub(AdvertClientInterface::class);
        $httpClient->method('get')->willReturn($response);

        $parser = $this->app->make(AdvertPageParserInterface::class);

        $fetcher = new AdvertDataFetcher($httpClient, $parser);
        $fetchedPrice = $fetcher->fetchPrice($url);

        $this->assertEquals($expectedPrice, $fetchedPrice);
        $this->assertEquals($expectedPrice->amount(), $fetchedPrice->amount());
        $this->assertEquals($expectedPrice->currency(), $fetchedPrice->currency());
    }
}
