<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Price;

use App\Bus\QueryBus\Query;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FetchPriceHistoryForSubscription
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Price
 */
class FetchPriceHistoryForSubscription extends Query
{
    /**
     * @param NotNegativeInteger $advertId
     * @param NotNegativeInteger $subscriptionId
     */
    public function __construct(
        private readonly NotNegativeInteger $advertId,
        private readonly NotNegativeInteger $subscriptionId,
    ) {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }

    /**
     * @return NotNegativeInteger
     */
    public function getSubscriptionId(): NotNegativeInteger
    {
        return $this->subscriptionId;
    }
}
