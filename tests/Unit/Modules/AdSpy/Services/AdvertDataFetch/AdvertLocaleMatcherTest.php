<?php declare(strict_types=1);

namespace Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Enum\AdvertUrlPart;
use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertLocaleMatcher;
use App\ValueObject\Url;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class AdvertLocaleMatcherTest
 *
 * @package Tests\Unit\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertLocaleMatcherTest extends TestCase
{
    /**
     * @return array[]
     * @throws InvalidUrlFormatException
     */
    public static function dataProvider(): array
    {
        return [
            [
                'url' => Url::make(
                    AdvertUrlPart::BASE_URL->value
                    . AdvertUrlPart::PREFIX_SEGMENT->value
                    . '/obyavlenie/'
                ),
                'expectedLocale' => Locale::RU
            ],
            [
                'url' => Url::make(
                    AdvertUrlPart::BASE_URL->value
                    . AdvertUrlPart::PREFIX_SEGMENT->value
                    . AdvertUrlPart::UA_LOCALE_SEGMENT->value
                    . '/obyavlenie/'
                ),
                'expectedLocale' => Locale::UA
            ],
        ];
    }

    /**
     * @param Url $url
     * @param Locale $expectedLocale
     * @return void
     */
    #[DataProvider('dataProvider')]
    public function test_get_locale(Url $url, Locale $expectedLocale)
    {
        $parser = new AdvertLocaleMatcher();
        $locale = $parser->getLocale($url);

        $this->assertEquals($expectedLocale, $locale);
        $this->assertEquals($expectedLocale->value, $locale->value);
        $this->assertEquals($expectedLocale->name, $locale->name);
    }
}
