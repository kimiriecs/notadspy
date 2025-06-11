<?php declare(strict_types=1);

namespace App\Modules\User\UseCase;

use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\User\Entities\User;
use App\Modules\User\QueryBus\Query\FetchUsersByIds as FetchUsersByIdsQuery;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FetchUsersByIds
 *
 * @package App\Modules\User\UseCase
 */
class FetchUsersByIds
{
    /**
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    /**
     * @param NotNegativeInteger[] $userIds
     * @return Collection<User>
     */
    public function fetch(array $userIds): Collection
    {
        /** @var Collection<User> $users */
        $users = $this->queryBus->dispatch(new FetchUsersByIdsQuery($userIds));

        return $users;
    }
}
