<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Subscription;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Subscription\DeleteSubscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;

/**
 * Class DeleteSubscriptionHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Subscription
 */
readonly class DeleteSubscriptionHandler implements CommandHandlerInterface
{
    /**
     * @param WriteSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private WriteSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param DeleteSubscription $command
     * @return bool
     */
    public function handle(Command $command): bool
    {
        return $this->repository->delete($command->getSubscriptionId());
    }
}
