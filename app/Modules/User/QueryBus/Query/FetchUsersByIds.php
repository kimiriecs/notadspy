<?php declare(strict_types=1);

namespace App\Modules\User\QueryBus\Query;

use App\Bus\QueryBus\Query;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FetchUsersByIds
 *
 * @package App\Modules\User\QueryBus\Query
 */
class FetchUsersByIds extends Query
{
    /**
     * @param NotNegativeInteger[] $usersIds
     */
    public function __construct(private readonly array $usersIds)
    {
    }

    /**
     * @return NotNegativeInteger[]
     */
    public function getUsersIds(): array
    {
        return $this->usersIds;
    }
}
