<?php

namespace App\Modules\AdSpy\Queue\Job;

use App\Interface\CommandBus\CommandBusInterface;
use App\Modules\AdSpy\CommandBus\Command\Price\BulkInsertPrice;
use App\Modules\AdSpy\Dto\PriceData;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AddNewAdvertsPricesJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * @param string $initialBatchId
     * @param PriceData[] $pricesData
     */
    public function __construct(
        private readonly string $initialBatchId,
        private readonly array $pricesData
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(CommandBusInterface $commandBus): void
    {
        $commandBus->dispatch(
            new BulkInsertPrice($this->initialBatchId, $this->pricesData)
        );
    }
}
