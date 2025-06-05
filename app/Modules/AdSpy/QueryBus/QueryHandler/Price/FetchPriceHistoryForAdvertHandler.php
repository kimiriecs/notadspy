<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\QueryHandler\Price;

use App\Bus\QueryBus\Query;
use App\Interface\QueryBus\QueryHandlerInterface;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForAdvert;

/**
 * Class FetchPriceHistoryForAdvertHandler
 *
 * @package App\Modules\AdSpy\QueryBus\QueryHandler\Price
 */
class FetchPriceHistoryForAdvertHandler implements QueryHandlerInterface
{
    /**
     * @param ReadPriceRepositoryInterface $repository
     */
    public function __construct(
        private ReadPriceRepositoryInterface $repository
    ) {
    }

    /**
     * @param FetchPriceHistoryForAdvert $command
     * @return array
     */
    public function handle(Query $command): array
    {
        return [];
    }
}
