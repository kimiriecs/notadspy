<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchSubscribersIdsByAdvertId;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Class FetchAdvertsSubscribersIdsInChunks
 *
 * @package App\Modules\AdSpy\UseCase
 */
class FetchAdvertsSubscribersIdsInChunks
{
    private const int CHUNK_SIZE = 100;

    /**
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {
    }

    /**
     * @return NotNegativeInteger[][]
     */
    public function fetch(NotNegativeInteger $advertId): array
    {
        $query = new FetchSubscribersIdsByAdvertId($advertId);
        /** @var SupportCollection<NotNegativeInteger> $subscribersIds */
        $subscribersIds = $this->queryBus->dispatch($query);

        return $subscribersIds->chunk(self::CHUNK_SIZE)->toArray();
    }
}
