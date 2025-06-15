<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Advert;

use App\Bus\QueryBus\Query;
use App\ValueObject\Url;

/**
 * Class FindAdvertByUrlWithTrashed
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Advert
 */
class FindAdvertByUrlWithTrashed extends Query
{
    /**
     * @param Url $advertUrl
     */
    public function __construct(private readonly Url $advertUrl)
    {
    }

    /**
     * @return Url
     */
    public function getAdvertUrl(): Url
    {
        return $this->advertUrl;
    }
}
