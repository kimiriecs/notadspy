<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface;

use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\ValueObject\Url;

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
}
