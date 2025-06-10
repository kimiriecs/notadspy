<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Subscription;

use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Repository\BaseReadRepository;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

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
     * @return LengthAwarePaginator
     */
    public function fetchAllUserSubscriptions(NotNegativeInteger $userId): LengthAwarePaginator
    {
        return $this->getBuilder()
            ->with(['advert', 'advert.prices'])
            ->where('user_id', $userId->asInt())
            ->paginate(10);
    }

    /**
     * @param NotNegativeInteger $advertId
     * @return SupportCollection<NotNegativeInteger>
     */
    public function fetchSubscribersIdsByAdvertId(NotNegativeInteger $advertId): SupportCollection
    {
        $userIds = $this->getBuilder()
            ->where('advert_id', $advertId)
            ->pluck('user_id');

        return $userIds->map(fn(int $id) => NotNegativeInteger::fromNumber($id));
    }
}
