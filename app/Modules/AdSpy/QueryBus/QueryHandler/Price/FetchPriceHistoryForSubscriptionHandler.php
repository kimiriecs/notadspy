<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Price;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForSubscription;

/**
 * Class FetchPriceHistoryForSubscriptionHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Price
 */
class FetchPriceHistoryForSubscriptionHandler implements QueryHandlerInterface
{
    /**
     * @param ReadPriceRepositoryInterface $repository
     */
    public function __construct(
        private ReadPriceRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchPriceHistoryForSubscription $command
     * @return array
     */
    public function handle(Query $command): array
    {
        return [];
    }
}
