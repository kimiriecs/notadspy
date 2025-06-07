<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface;

use App\Modules\AdSpy\Dto\AdvertData;
use App\ValueObject\Price;
use App\ValueObject\Url;

/**
 * Interface AdvertDataFetcherInterface
 *
 * @package App\Modules\AdSpy\Interface
 */
interface AdvertDataFetcherInterface
{
    /**
     * @param Url $url
     * @return AdvertData
     */
    public function fetch(Url $url): AdvertData;

    /**
     * @param Url $url
     * @return Price
     */
    public function fetchPrice(Url $url): Price;
}
