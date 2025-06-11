<?php declare(strict_types=1);

namespace App\Interface\Repository;

use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface ReadRepositoryInterface
 *
 * @package App\Interface\Repository
 */
interface ReadRepositoryInterface
{
    /**
     * @param NotNegativeInteger $id
     * @return Model|null
     */
    public function findById(NotNegativeInteger $id): ?Model;
}
