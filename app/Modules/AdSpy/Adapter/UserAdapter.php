<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Adapter;

use App\Modules\AdSpy\Interface\Adapter\UserAdapterInterface;
use App\Modules\User\Interface\UserGateWayInterface;
use App\Modules\User\Entities\User;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserAdapter
 *
 * @package App\Modules\AdSpy\Adapter
 */
readonly class UserAdapter implements UserAdapterInterface
{
    /**
     * @param UserGateWayInterface $userGateWay
     */
    public function __construct(
        private UserGateWayInterface $userGateWay
    ) {
    }

    /**
     * @param NotNegativeInteger[] $usersIds
     * @return Collection<User>
     */
    public function fetchUsersByIds(array $usersIds): Collection
    {
        return $this->userGateWay->fetchUsersByIds($usersIds);
    }
}
