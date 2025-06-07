<?php declare(strict_types=1);

namespace App\Modules\User\GateWay;

use App\Modules\User\Interface\UserGateWayInterface;
use App\Modules\User\Entities\User;
use App\Modules\User\UseCase\FetchUsersByIds;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserGateWay
 *
 * @package App\Modules\AdSpy\GateWay
 */
readonly class UserGateWay implements UserGateWayInterface
{
    public function __construct(
        private FetchUsersByIds $usersByIds
    ) {
    }

    /**
     * @param NotNegativeInteger[] $usersIds
     * @return Collection<User>
     */
    public function fetchUsersByIds(array $usersIds): Collection
    {
        return $this->usersByIds->fetch($usersIds);
    }
}
