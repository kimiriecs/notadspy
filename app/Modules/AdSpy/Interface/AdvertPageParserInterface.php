<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface;

use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Enum\Locale;
use App\ValueObject\Price;
use App\ValueObject\Url;

/**
 * Interface AdvertPageParserInterface
 *
 * @package App\Modules\AdSpy\Interface
 */
interface AdvertPageParserInterface
{
    /**
     * @param Url $url
     * @param string $data
     * @param Locale $locale
     * @return AdvertData
     */
    public function parse(Url $url, string $data, Locale $locale): AdvertData;

    /**
     * @param string $data
     * @return Price
     */
    public function parsePrice(string $data): Price;
}
