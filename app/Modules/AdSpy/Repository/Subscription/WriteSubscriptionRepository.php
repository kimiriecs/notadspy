<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Subscription;

use App\Modules\AdSpy\Dto\SubscriptionData;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Repository\BaseWriteRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class WriteSubscriptionRepository
 *
 * @package App\Modules\AdSpy\Repository\Subscription
 */
class WriteSubscriptionRepository extends BaseWriteRepository implements WriteSubscriptionRepositoryInterface
{
    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        return Subscription::query();
    }

    /**
     * @param SubscriptionData $subscription
     * @return Subscription
     */
    public function store(SubscriptionData $subscription): Subscription
    {
        /** @var Subscription $subscription */
        $subscription = $this->getBuilder()->create($subscription->jsonSerialize());

        return $subscription;
    }

    /**
     * @param NotNegativeInteger $subscriptionId
     * @param SubscriptionData $subscription
     * @return Subscription
     */
    public function update(NotNegativeInteger $subscriptionId, SubscriptionData $subscription): Subscription
    {
        /** @var Subscription|null $subscription */
        $existingSubscription = $this->getBuilder()->firstWhere('id', $subscriptionId->asInt());
        if (!$existingSubscription instanceof Subscription) {
            throw new ModelNotFoundException("Subscription with provided ID = {${$subscriptionId->asInt()}} not found");
        }

        $success = $existingSubscription->update($subscription->jsonSerialize());
        if (!$success) {
            throw new ModelNotFoundException("Unable to update subscription with provided ID = {${$subscriptionId->asInt()}}");
        }

        return $existingSubscription;
    }
}
