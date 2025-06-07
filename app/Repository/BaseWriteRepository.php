<?php declare(strict_types=1);

namespace App\Repository;

use App\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BaseWriteRepository
 *
 * @package App\Repository
 */
abstract class BaseWriteRepository
{
    /**
     * @return Builder
     */
    abstract protected function getBuilder(): Builder;

    /**
     * @param NotNegativeInteger $id
     * @return bool
     */
    public function delete(NotNegativeInteger $id): bool
    {
        $id = $id->asInt();
        $model = $this->getBuilder()->firstWhere('id', $id);
        if (!$model) {
            throw new ModelNotFoundException("Subscription with provided ID = $id not found");
        }

        $success = $model->delete();
        if (!$success) {
            throw new ModelNotFoundException("Unable to delete subscription with provided ID = $id");
        }

        return $success;
    }
}
