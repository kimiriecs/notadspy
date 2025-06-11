<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Advert;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertById;

/**
 * Class FindAdvertByIdHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Advert
 */
readonly class FindAdvertByIdHandler implements QueryHandlerInterface
{
    /**
     * @param ReadAdvertRepositoryInterface $repository
     */
    public function __construct(
        private ReadAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param FindAdvertById $query
     * @return Advert|null
     */
    public function handle(Query $query): ?Advert
    {
        /** @var Advert|null $advert */
        $advert = $this->repository->findById($query->getAdvertId());

        return $advert;
    }
}
