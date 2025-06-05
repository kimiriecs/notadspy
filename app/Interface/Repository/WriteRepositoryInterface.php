<?php declare(strict_types=1);

namespace App\Interface\Repository;

use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Interface WriteRepositoryInterface
 *
 * @package App\Interface\Repository
 */
interface WriteRepositoryInterface
{
    /**
     * @param NotNegativeInteger $id
     * @return bool
     */
    public function delete(NotNegativeInteger $id): bool;
}
