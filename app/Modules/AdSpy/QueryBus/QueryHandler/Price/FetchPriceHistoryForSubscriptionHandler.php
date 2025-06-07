<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Price;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForSubscription;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FetchPriceHistoryForSubscriptionHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Price
 */
readonly class FetchPriceHistoryForSubscriptionHandler implements QueryHandlerInterface
{
    /**
     * @param ReadPriceRepositoryInterface $repository
     */
    public function __construct(
        private ReadPriceRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchPriceHistoryForSubscription $query
     * @return Collection<Price>
     */
    public function handle(Query $query): Collection
    {
        return $this->repository->fetchHistoryForSubscription(
            $query->getAdvertId(),
            $query->getSubscriptionId()
        );
    }
}
