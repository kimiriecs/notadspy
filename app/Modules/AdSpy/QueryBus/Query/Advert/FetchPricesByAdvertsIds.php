<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Advert;

use App\Bus\QueryBus\Query;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FetchAdvertsPricesByIds
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Advert
 */
class FetchPricesByAdvertsIds extends Query
{
    /**
     * @param array<NotNegativeInteger> $advertsIds
     */
    public function __construct(
        private readonly array $advertsIds
    ) {
    }

    /**
     * @return NotNegativeInteger[]
     */
    public function getAdvertsIds(): array
    {
        return $this->advertsIds;
    }
}
