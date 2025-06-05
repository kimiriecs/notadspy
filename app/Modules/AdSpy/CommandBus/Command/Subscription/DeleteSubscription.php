<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Subscription;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Class DeleteSubscription
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Subscription
 */
class DeleteSubscription extends Command
{
    public function __construct(private readonly NotNegativeInteger $subscriptionId)
    {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getSubscriptionId(): NotNegativeInteger
    {
        return $this->subscriptionId;
    }
}
