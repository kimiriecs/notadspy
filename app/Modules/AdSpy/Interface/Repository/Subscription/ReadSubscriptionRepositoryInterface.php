<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Subscription;

use App\Interface\Repository\ReadRepositoryInterface;
use App\Modules\AdSpy\Entities\Subscription;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Interface ReadSubscriptionRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Subscription
 */
interface ReadSubscriptionRepositoryInterface extends ReadRepositoryInterface
{
    /**
     * @param NotNegativeInteger $userId
     * @param NotNegativeInteger $advertId
     * @return Subscription|null
     */
    public function findUserSubscriptionByAvertId(NotNegativeInteger $userId, NotNegativeInteger $advertId): ?Subscription;

    /**
     * @param NotNegativeInteger $userId
     * @return LengthAwarePaginator<Subscription>
     */
    public function fetchAllUserSubscriptions(NotNegativeInteger $userId): LengthAwarePaginator;

    /**
     * @param NotNegativeInteger $advertId
     * @return SupportCollection<NotNegativeInteger>
     */
    public function fetchSubscribersIdsByAdvertId(NotNegativeInteger $advertId): SupportCollection;
}
