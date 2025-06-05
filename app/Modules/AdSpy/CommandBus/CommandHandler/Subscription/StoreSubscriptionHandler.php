<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Subscription;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Subscription\StoreSubscription;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;

/**
 * Class StoreSubscriptionHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Subscription
 */
readonly class StoreSubscriptionHandler implements CommandHandlerInterface
{
    /**
     * @param WriteSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private WriteSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param StoreSubscription $command
     * @return Subscription
     */
    public function handle(Command $command): Subscription
    {
        return $this->repository->store($command->getData());
    }
}
