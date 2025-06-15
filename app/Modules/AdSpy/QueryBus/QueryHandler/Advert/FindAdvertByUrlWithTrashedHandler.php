<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Advert;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertByUrlWithTrashed;

/**
 * Class FindAdvertByUrlWithTrashedHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Advert
 */
readonly class FindAdvertByUrlWithTrashedHandler implements QueryHandlerInterface
{
    /**
     * @param ReadAdvertRepositoryInterface $repository
     */
    public function __construct(
        private ReadAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param FindAdvertByUrlWithTrashed $query
     * @return Advert|null
     */
    public function handle(Query $query): ?Advert
    {
        return $this->repository->findByUrlWithTrashed($query->getAdvertUrl());
    }
}
