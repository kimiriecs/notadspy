<?php declare(strict_types=1);

namespace App\Modules\User\QueryBus\QueryHandler;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\User\Interface\ReadUserRepositoryInterface;
use App\Modules\User\Entities\User;
use App\Modules\User\QueryBus\Query\FetchUsersByIds;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FetchUsersByIdsHandler
 *
 * @package App\Modules\User\QueryBus\QueryHandler
 */
class FetchUsersByIdsHandler implements QueryHandlerInterface
{
    public function __construct(
        private ReadUserRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchUsersByIds $query
     * @return Collection<User>
     */
    public function handle(Query $query): Collection
    {
        return $this->repository->fetchUsersByIds($query->getUsersIds());
    }
}
