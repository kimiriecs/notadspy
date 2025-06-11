<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Adapter;

use App\Modules\User\Entities\User;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserAdapterInterface
 *
 * @package App\Modules\AdSpy\Interface\Adapter
 */
interface UserAdapterInterface
{
    /**
     * @param NotNegativeInteger[] $usersIds
     * @return Collection<User>
     */
    public function fetchUsersByIds(array $usersIds): Collection;
}
