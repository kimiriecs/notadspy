<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Subscription;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchAllUserSubscriptions;
use Illuminate\Support\Facades\DB;

/**
 * Class FetchAllUserSubscriptionsHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Subscription
 */
class FetchAllUserSubscriptionsHandler implements QueryHandlerInterface
{
    /**
     * @param ReadSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private ReadSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchAllUserSubscriptions $command
     * @return array
     */
    public function handle(Query $command): array
    {
        $subscriptions = $this->repository->fetchAllUserSubscriptions($command->getUserId());

        return $subscriptions->toArray();
    }
}
