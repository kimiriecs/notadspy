<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Subscription;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindUserSubscriptionByAdvertId;

/**
 * Class FindUserSubscriptionByUrlHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Subscription
 */
readonly class FindUserSubscriptionByAdvertIdHandler implements QueryHandlerInterface
{
    /**
     * @param ReadSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private ReadSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param FindUserSubscriptionByAdvertId $command
     * @return Subscription|null
     */
    public function handle(Query $command): ?Subscription
    {
        return $this->repository->findUserSubscriptionByAvertId(
            $command->getUserId(),
            $command->getAdvertId()
        );
    }
}
