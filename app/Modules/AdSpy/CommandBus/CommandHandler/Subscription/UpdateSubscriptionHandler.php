<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Subscription;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Subscription\UpdateSubscription;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;

/**
 * Class UpdateSubscriptionHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Subscription
 */
class UpdateSubscriptionHandler implements CommandHandlerInterface
{
    /**
     * @param WriteSubscriptionRepositoryInterface $repository
     */
    public function __construct(
        private WriteSubscriptionRepositoryInterface $repository
    ) {
    }

    /**
     * @param UpdateSubscription $command
     * @return Subscription
     */
    public function handle(Command $command): Subscription
    {
        return new Subscription;
    }
}
