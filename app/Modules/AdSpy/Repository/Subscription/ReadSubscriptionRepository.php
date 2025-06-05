<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Subscription;

use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Repository\BaseReadRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ReadSubscriptionRepository
 *
 * @package App\Modules\AdSpy\Repository\Subscription
 */
class ReadSubscriptionRepository extends BaseReadRepository implements ReadSubscriptionRepositoryInterface
{
    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        return Subscription::query();
    }

    /**
     * @param NotNegativeInteger $userId
     * @param NotNegativeInteger $advertId
     * @return Subscription|null
     */
    public function findUserSubscriptionByAvertId(NotNegativeInteger $userId, NotNegativeInteger $advertId): ?Subscription
    {
        return $this->getBuilder()
            ->with('advert')
            ->where('advert_id', $advertId->asInt())
            ->firstWhere('user_id', $userId->asInt());
    }

    /**
     * @param NotNegativeInteger $userId
     * @return Collection<Subscription>
     */
    public function fetchAllUserSubscriptions(NotNegativeInteger $userId): Collection
    {
        return $this->getBuilder()
            ->with(['advert', 'advert.prices'])
            ->where('user_id', $userId->asInt())
            ->get();
    }
}
