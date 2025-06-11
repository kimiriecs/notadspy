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
        $isToday = str_starts_with(mb_strtolower($date), 'сьогодні');
        $date = trim(str_replace('р.', '', $date));
        $dateTime = Carbon::parseFromLocale($date, $locale->value, TimeZone::GMT->value)
            ->setTimezone(TimeZone::KYIV->value)
            ->toDateTimeImmutable();

        return $isToday ? $dateTime : $dateTime->setTime(0,0);
    }
}
