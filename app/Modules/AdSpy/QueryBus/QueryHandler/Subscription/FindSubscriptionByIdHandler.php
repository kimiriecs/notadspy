<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Subscription;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindSubscriptionById;

/**
 * Class FindSubscriptionByIdHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Subscription
 */
readonly class FindSubscriptionByIdHandler implements QueryHandlerInterface
{
    /**
     * @param ReadSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private ReadSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param FindSubscriptionById $query
     * @return Subscription|null
     */
    public function handle(Query $query): ?Subscription
    {
        /** @var Subscription|null $subscription */
        $subscription = $this->repository->findById($query->getSubscriptionId());

        return $subscription;
    }
}
