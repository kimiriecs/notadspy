<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Price;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Price\BulkInsertPrice;
use App\Modules\AdSpy\Event\NewPricesInsertionFinished;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;

/**
 * Class BulkInsertPriceHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Price
 */
readonly class BulkInsertPriceHandler implements CommandHandlerInterface
{
    /**
     * @param WritePriceRepositoryInterface $repository
     */
    public function __construct(
        private WritePriceRepositoryInterface $repository
    ) {
    }

    /**
     * @param BulkInsertPrice $command
     * @return bool
     */
    public function handle(Command $command): bool
    {
        $this->repository->bulkInsert($command->getPrices());
        NewPricesInsertionFinished::dispatch($command->getBatchId());

        return true;
    }
}
