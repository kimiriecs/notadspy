<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Interface\CommandBus\CommandBusInterface;
use App\Modules\AdSpy\CommandBus\Command\Subscription\ToggleSubscriptionStatus as ToggleSubscriptionStatusCommand;
use App\Modules\AdSpy\Entities\Subscription;
use App\ValueObject\NotNegativeInteger;

/**
 * Class ToggleSubscriptionStatus
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class ToggleSubscriptionStatus
{
    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @param NotNegativeInteger $subscriptionId
     * @return Subscription
     */
    public function execute(NotNegativeInteger $subscriptionId): Subscription
    {
        return $this->commandBus->dispatch(
            new ToggleSubscriptionStatusCommand($subscriptionId)
        );
    }
}
