<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Subscription;

use App\Bus\QueryBus\Query;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Class FetchAllUserSubscriptions
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Subscription
 */
class FetchAllUserSubscriptions extends Query
{
    /**
     * @param NotNegativeInteger $userId
     */
    public function __construct(private readonly NotNegativeInteger $userId)
    {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getUserId(): NotNegativeInteger
    {
        return $this->userId;
    }
}
