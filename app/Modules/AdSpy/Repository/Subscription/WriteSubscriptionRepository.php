<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Subscription;

use App\Modules\AdSpy\Dto\SubscriptionData;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Enum\SubscriptionStatus;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;
use App\Repository\BaseWriteRepository;
use App\ValueObject\NotNegativeInteger;
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
     * @param NotNegativeInteger $subscriptionId
     * @return Subscription
     */
    private function getSubscriptionById(NotNegativeInteger $subscriptionId): Subscription
    {
        /** @var Subscription|null $subscription */
        $existingSubscription = $this->getBuilder()->firstWhere('id', $subscriptionId);
        if (!$existingSubscription instanceof Subscription) {
            throw new ModelNotFoundException("Subscription with provided ID = $subscriptionId not found");
        }

        return $existingSubscription;
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
        $existingSubscription = $this->getSubscriptionById($subscriptionId);
        $subscriptionId = $subscriptionId->asInt();
        $success = $existingSubscription->update($subscription->jsonSerialize());
        if (!$success) {
            throw new ModelNotFoundException("Unable to update subscription with provided ID = $subscriptionId");
        }

        return $existingSubscription;
    }

    /**
     * @param NotNegativeInteger $subscriptionId
     * @return Subscription
     */
    public function toggleStatus(NotNegativeInteger $subscriptionId): Subscription
    {
        $existingSubscription = $this->getSubscriptionById($subscriptionId);
        $status = $existingSubscription->status === SubscriptionStatus::DISABLED->value
            ? SubscriptionStatus::ACTIVE->value
            : SubscriptionStatus::DISABLED->value;

        $success = $existingSubscription->update(['status' => $status]);
        if (!$success) {
            throw new ModelNotFoundException("Unable to update subscription with provided ID = $subscriptionId");
        }

        return $existingSubscription;
    }
}
