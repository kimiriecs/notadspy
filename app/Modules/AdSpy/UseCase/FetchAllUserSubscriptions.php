<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchAllUserSubscriptions as FetchAllUserSubscriptionsQuery;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class FetchAllUserSubscriptions
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class FetchAllUserSubscriptions
{
    /**
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    /**
     * @return LengthAwarePaginator<Subscription>
     */
    public function fetch(NotNegativeInteger $userId): LengthAwarePaginator
    {
        $query = new FetchAllUserSubscriptionsQuery($userId);

        return $this->queryBus->dispatch($query);
    }
}
