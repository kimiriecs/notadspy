<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Subscription;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchSubscribersIdsByAdvertId;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Class FetchSubscribersIdsByAdvertIdHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Subscription
 */
readonly class FetchSubscribersIdsByAdvertIdHandler implements QueryHandlerInterface
{
    /**
     * @param ReadSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private ReadSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchSubscribersIdsByAdvertId $query
     * @return SupportCollection<NotNegativeInteger>
     */
    public function handle(Query $query): SupportCollection
    {
        return $this->repository->fetchSubscribersIdsByAdvertId($query->getAdvertId());
    }
}
