<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Price;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForAdvert;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FetchPriceHistoryForAdvertHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Price
 */
readonly class FetchPriceHistoryForAdvertHandler implements QueryHandlerInterface
{
    /**
     * @param ReadPriceRepositoryInterface $repository
     */
    public function __construct(
        private ReadPriceRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchPriceHistoryForAdvert $query
     * @return Collection<Price>
     */
    public function handle(Query $query): Collection
    {
        return $this->repository->fetchHistoryForAdvert($query->getAdvertId());
    }
}
