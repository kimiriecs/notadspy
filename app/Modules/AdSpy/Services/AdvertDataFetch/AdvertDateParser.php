<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Enum\TimeZone;
use Carbon\Carbon;
use DateTimeImmutable;

/**
 * Class AdvertDateParser
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertDateParser
{
    /**
     * @param string $date
     * @param Locale $locale
     * @return DateTimeImmutable
     */
    public function parse(string $date, Locale $locale): DateTimeImmutable
    {
        $date = trim(str_replace('р.', '', $date));
        return Carbon::parseFromLocale($date, $locale->value, TimeZone::GMT->value)
            ->setTimezone(TimeZone::KYIV->value)
            ->toDateTimeImmutable();
    }
}
