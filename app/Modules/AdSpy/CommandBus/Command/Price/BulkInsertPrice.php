<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Price;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\Dto\PriceData;

/**
 * Class BulkInsertPrice
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Price
 */
class BulkInsertPrice extends Command
{
    /**
     * @param string $initialBatchId
     * @param array<PriceData> $prices
     */
    public function __construct(
        private readonly string $initialBatchId,
        private readonly array $prices
    ) {
    }

    /**
     * @return string
     */
    public function getBatchId(): string
    {
        return $this->initialBatchId;
    }

    /**
     * @return array<PriceData>
     */
    public function getPrices(): array
    {
        return $this->prices;
    }
}
