<?php declare(strict_types=1);

namespace App\Modules\User\Repository;

use App\Modules\User\Interface\ReadUserRepositoryInterface;
use App\Modules\User\Entities\User;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ReadUserRepository
 *
 * @package App\Modules\User\Repository
 */
class ReadUserRepository implements ReadUserRepositoryInterface
{
    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        return User::query();
    }

    /**
     * @param NotNegativeInteger $id
     * @return User|null
     */
    public function findById(NotNegativeInteger $id): ?User
    {
        return $this->getBuilder()->firstWhere('id', $id->asInt());
    }

    /**
     * @param NotNegativeInteger[] $usersIds
     * @return Collection<User>
     */
    public function fetchUsersByIds(array $usersIds): Collection
    {
        $usersIds = array_map(fn(NotNegativeInteger $id) => $id->asInt(), $usersIds);

        return $this->getBuilder()->whereIn('id', $usersIds)->get();
    }
}
