<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Advert;

use App\Bus\QueryBus\Query;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FindAdvertById
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Advert
 */
class FindAdvertById extends Query
{
    /**
     * @param NotNegativeInteger $advertId
     */
    public function __construct(private readonly NotNegativeInteger $advertId)
    {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }
}
