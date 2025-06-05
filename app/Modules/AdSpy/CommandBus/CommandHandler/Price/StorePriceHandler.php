<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Price;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Price\StorePrice;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;

/**
 * Class StorePriceHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Price
 */
readonly class StorePriceHandler implements CommandHandlerInterface
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
     * @return Price
     */
    public function handle(Command $command): Price
    {
        return $this->repository->store($command->getAdvertId(), $command->getPriceData());
    }
}
