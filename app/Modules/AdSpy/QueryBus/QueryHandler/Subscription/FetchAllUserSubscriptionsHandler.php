<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Subscription;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchAllUserSubscriptions;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class FetchAllUserSubscriptionsHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Subscription
 */
readonly class FetchAllUserSubscriptionsHandler implements QueryHandlerInterface
{
    /**
     * @param ReadSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private ReadSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchAllUserSubscriptions $query
     * @return LengthAwarePaginator<Subscription>
     */
    public function handle(Query $query): LengthAwarePaginator
    {
        return $this->repository->fetchAllUserSubscriptions($query->getUserId());
    }
}
