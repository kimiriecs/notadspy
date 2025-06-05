<?php declare(strict_types=1);

namespace App\Repository;

use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
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
        $model = $this->getBuilder()->firstWhere('id', $id->asInt());
        if (!$model) {
            throw new ModelNotFoundException("Subscription with provided ID = {${$id->asInt()}} not found");
        }

        $success = $model->delete();
        if (!$success) {
            throw new ModelNotFoundException("Unable to delete subscription with provided ID = {${$id->asInt()}}");
        }

        return $success;
    }
}
