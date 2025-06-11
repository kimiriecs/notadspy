<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Subscription;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\Dto\SubscriptionData;

/**
 * Class StoreSubscription
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Subscription
 */
class StoreSubscription extends Command
{
    /**
     * @param SubscriptionData $data
     */
    public function __construct(private readonly SubscriptionData $data)
    {
    }

    /**
     * @return SubscriptionData
     */
    public function getData(): SubscriptionData
    {
        return $this->data;
    }
}
