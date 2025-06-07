<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Modules\AdSpy\Enum\AdvertUrlPart;
use App\Modules\AdSpy\Enum\Locale;
use App\ValueObject\Url;

/**
 * Class AdvertLocaleMatcher
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
class AdvertLocaleMatcher
{
    /**
     * @param Url $url
     * @return Locale
     */
    public function getLocale(Url $url): Locale
    {
        $pattern = "#" . AdvertUrlPart::BASE_URL->value . "(?<locale>" . AdvertUrlPart::UA_LOCALE_SEGMENT->value . ").*$#";
        preg_match_all($pattern, $url->value(), $matches, PREG_UNMATCHED_AS_NULL);

        $uaLocale = $matches['locale'] ?? null;

        return $uaLocale ? Locale::UA : Locale::RU;
    }
}
