<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Advert;

use App\Bus\QueryBus\Query;
use App\Modules\AdSpy\ValueObject\Url;

/**
 * Class FindAdvertByUrl
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Advert
 */
class FindAdvertByUrl extends Query
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
