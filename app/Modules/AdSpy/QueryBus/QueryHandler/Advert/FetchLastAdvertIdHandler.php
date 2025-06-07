<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Advert;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FetchLastAdvertId;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FetchLastAdvertIdHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Advert
 */
readonly class FetchLastAdvertIdHandler implements QueryHandlerInterface
{
    /**
     * @param ReadAdvertRepositoryInterface $repository
     */
    public function __construct(
        private ReadAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchLastAdvertId $query
     * @return NotNegativeInteger
     */
    public function handle(Query $query): NotNegativeInteger
    {
        return $this->repository->fetchLastId();
    }
}
