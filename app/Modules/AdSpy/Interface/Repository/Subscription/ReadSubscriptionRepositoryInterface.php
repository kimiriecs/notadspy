<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Subscription;

use App\Interface\Repository\ReadRepositoryInterface;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection<Subscription>
     */
    public function fetchAllUserSubscriptions(NotNegativeInteger $userId): Collection;
}
