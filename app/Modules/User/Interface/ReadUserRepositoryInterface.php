<?php declare(strict_types=1);

namespace App\Modules\User\Interface;

use App\Interface\Repository\ReadRepositoryInterface;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ReadUserRepositoryInterface
 *
 * @package App\Modules\User\Interface
 */
interface ReadUserRepositoryInterface extends ReadRepositoryInterface
{
    /**
     * @param NotNegativeInteger[] $usersIds
     * @return Collection
     */
    public function fetchUsersByIds(array $usersIds): Collection;
}
