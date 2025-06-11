<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Subscription;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Subscription\ToggleSubscriptionStatus;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;

/**
 * Class ToggleSubscriptionStatusHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Subscription
 */
readonly class ToggleSubscriptionStatusHandler implements CommandHandlerInterface
{
    /**
     * @param WriteSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private WriteSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param ToggleSubscriptionStatus $command
     * @return Subscription
     */
    public function handle(Command $command): Subscription
    {
        return $this->repository->toggleStatus($command->getSubscriptionId());
    }
}
