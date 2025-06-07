<?php declare(strict_types=1);

namespace App\Modules\User\Interface;

use App\Modules\User\Entities\User;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserGateWayInterface
 *
 * @package App\Modules\User\Interface
 */
interface UserGateWayInterface
{
    /**
     * @param NotNegativeInteger[] $usersIds
     * @return Collection<User>
     */
    public function fetchUsersByIds(array $usersIds): Collection;
}
