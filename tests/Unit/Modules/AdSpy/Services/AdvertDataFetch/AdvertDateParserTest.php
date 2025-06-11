<?php declare(strict_types=1);

namespace Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch;

use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Enum\TimeZone;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertDateParser;
use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class AdvertDateParserTest
 *
 * @package Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertDateParserTest extends TestCase
{
    /**
     * @return array[]
     * @throws DateInvalidTimeZoneException
     * @throws DateMalformedStringException
     */
    public static function dataProvider(): array
    {
        $timezone = new DateTimeZone(TimeZone::KYIV->value);
        return [
            [
                'dateStringFetched' => '12 червня 2025р.',
                'expectedDate' => new DateTimeImmutable('2025-06-12', $timezone),
                'locale' => Locale::UA
            ],
            [
                'dateStringFetched' => 'Сьогодні о 12:47', // 12:47 - in response fetched in GMT, 15:47 - on page displayed in Europe/Kyiv
                'expectedDate' => new DateTimeImmutable('now', $timezone)->setTime(15,47),
                'locale' => Locale::UA
            ]
        ];
    }

    /**
     * @param string $dateStringFetched
     * @param DateTimeImmutable $expectedDate
     * @param Locale $locale
     * @return void
     * @throws BindingResolutionException
     */
    #[DataProvider('dataProvider')]
    public function test_date(
        string $dateStringFetched,
        DateTimeImmutable $expectedDate,
        Locale $locale
    ) {
        $parser = $this->app->make(AdvertDateParser::class);
        $parsedDate = $parser->parse($dateStringFetched, $locale);

        $this->assertEquals($expectedDate, $parsedDate);
        $this->assertEquals($expectedDate->format('Y-m-d H:i:s'), $parsedDate->format('Y-m-d H:i:s'));
    }
}
