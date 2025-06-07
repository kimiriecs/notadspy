<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Subscription;

use App\Bus\QueryBus\Query;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FindSubscriptionById
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Subscription
 */
class FindSubscriptionById extends Query
{
    /**
     * @param NotNegativeInteger $subscriptionId
     */
    public function __construct(private readonly NotNegativeInteger $subscriptionId)
    {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getSubscriptionId(): NotNegativeInteger
    {
        return $this->subscriptionId;
    }
}
