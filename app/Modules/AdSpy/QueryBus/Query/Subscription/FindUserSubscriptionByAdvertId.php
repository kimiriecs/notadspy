<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Subscription;

use App\Bus\QueryBus\Query;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Class FindUserSubscriptionByAdvertId
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Subscription
 */
class FindUserSubscriptionByAdvertId extends Query
{
    /**
     * @param NotNegativeInteger $userId
     * @param NotNegativeInteger $advertId
     */
    public function __construct(
        private readonly NotNegativeInteger $userId,
        private readonly NotNegativeInteger $advertId
    ) {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getUserId(): NotNegativeInteger
    {
        return $this->userId;
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }
}
