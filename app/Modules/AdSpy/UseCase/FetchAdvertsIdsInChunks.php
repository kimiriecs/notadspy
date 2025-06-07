<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Exception\InvalidNumberFormatException;
use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FetchLastAdvertId;
use App\ValueObject\NotNegativeInteger;

/**
 * Class FetchAdvertsIdsInChunks
 *
 * @package App\Modules\AdSpy\UseCase
 */
class FetchAdvertsIdsInChunks
{
    private const int CHUNK_SIZE = 100;
    private const int FIRST_ID = 1;

    /**
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {
    }

    /**
     * @return NotNegativeInteger[][]
     * @throws InvalidNumberFormatException
     */
    public function fetch(): array
    {
        /** @var NotNegativeInteger $lastAdvertId */
        $lastAdvertId = $this->queryBus->dispatch(new FetchLastAdvertId());
        $ids = array_map(
            fn(int $id) => NotNegativeInteger::fromNumber($id),
            range(self::FIRST_ID, $lastAdvertId->asInt())
        );

        return array_chunk($ids, self::CHUNK_SIZE);
    }
}
