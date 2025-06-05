<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Interface\CommandBus\CommandBusInterface;
use App\Modules\AdSpy\CommandBus\Command\Price\DeletePricesByAdvertId;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Class DeleteAdvertPrices
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class DeleteAdvertPrices
{
    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @param NotNegativeInteger $advertId
     * @return bool
     */
    public function execute(NotNegativeInteger $advertId): bool
    {
        return $this->commandBus->dispatch(
            new DeletePricesByAdvertId($advertId)
        );
    }
}
