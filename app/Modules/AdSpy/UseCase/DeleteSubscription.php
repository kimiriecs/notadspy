<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Interface\CommandBus\CommandBusInterface;
use App\Modules\AdSpy\CommandBus\Command\Subscription\DeleteSubscription as DeleteSubscriptionCommand;
use App\Modules\AdSpy\Entities\Subscription;
use App\ValueObject\NotNegativeInteger;

/**
 * Class DeleteSubscription
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class DeleteSubscription
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
     * @return bool
     */
    public function execute(NotNegativeInteger $subscriptionId): bool
    {
        return $this->commandBus->dispatch(
            new DeleteSubscriptionCommand($subscriptionId)
        );
    }
}
