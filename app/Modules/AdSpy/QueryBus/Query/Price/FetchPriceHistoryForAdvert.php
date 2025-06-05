<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Price;

use App\Bus\QueryBus\Query;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Class FetchPriceHistoryForAdvert
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Price
 */
class FetchPriceHistoryForAdvert extends Query
{
    /**
     * @param NotNegativeInteger $advertId
     */
    public function __construct(
        private readonly NotNegativeInteger $advertId,
    ) {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }
}
