<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Price;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Price\StorePrice;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;

/**
 * Class DeletePricesByAdvertIdHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Price
 */
readonly class DeletePricesByAdvertIdHandler implements CommandHandlerInterface
{
    /**
     * @param WritePriceRepositoryInterface $repository
     */
    public function __construct(
        private WritePriceRepositoryInterface $repository
    ) {
    }

    /**
     * @param StorePrice $command
     * @return bool
     */
    public function handle(Command $command): bool
    {
        return $this->repository->deletePricesByAdvertId($command->getAdvertId());
    }
}
