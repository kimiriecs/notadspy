<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Subscription;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindSubscriptionByUrl;

/**
 * Class FindSubscriptionByUrlHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Subscription
 */
class FindSubscriptionByUrlHandler implements QueryHandlerInterface
{
    /**
     * @param ReadSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private ReadSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param FindSubscriptionByUrl $command
     * @return array
     */
    public function handle(Query $command): array
    {
        return [];
    }
}
