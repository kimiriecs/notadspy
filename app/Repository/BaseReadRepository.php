<?php declare(strict_types=1);

namespace App\Repository;

use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseReadRepository
 *
 * @package App\Repository
 */
abstract class BaseReadRepository
{
    /**
     * @return Builder
     */
    abstract protected function getBuilder(): Builder;

    /**
     * @param NotNegativeInteger $id
     * @return Model|null
     */
    public function findById(NotNegativeInteger $id): ?Model
    {
        return $this->getBuilder()->firstWhere('id', $id->asInt());
    }
}
