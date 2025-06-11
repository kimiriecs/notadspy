<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Advert;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FetchPricesByAdvertsIds;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FetchPricesByAdvertsIdsHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Advert
 */
readonly class FetchPricesByAdvertsIdsHandler implements QueryHandlerInterface
{
    /**
     * @param ReadAdvertRepositoryInterface $repository
     */
    public function __construct(
        private ReadAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchPricesByAdvertsIds $query
     * @return Collection
     */
    public function handle(Query $query): Collection
    {
        return $this->repository->fetchPricesByAdvertsIds($query->getAdvertsIds());
    }
}
