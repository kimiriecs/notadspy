<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Subscription;

use App\Bus\CommandBus\Command;
use App\ValueObject\NotNegativeInteger;

/**
 * Class ToggleSubscriptionStatus
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Subscription
 */
class ToggleSubscriptionStatus extends Command
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
