<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Subscription;

use App\Modules\AdSpy\Dto\SubscriptionData;
use App\Modules\AdSpy\Entities\Subscription;
use App\ValueObject\NotNegativeInteger;

/**
 * Interface WriteSubscriptionRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Subscription
 */
interface WriteSubscriptionRepositoryInterface
{
    /**
     * @param SubscriptionData $subscription
     * @return Subscription
     */
    public function store(SubscriptionData $subscription): Subscription;

    /**
     * @param NotNegativeInteger $subscriptionId
     * @param SubscriptionData $subscription
     * @return Subscription
     */
    public function update(NotNegativeInteger $subscriptionId, SubscriptionData $subscription): Subscription;

    /**
     * @param NotNegativeInteger $subscriptionId
     * @return bool
     */
    public function delete(NotNegativeInteger $subscriptionId): bool;
}
