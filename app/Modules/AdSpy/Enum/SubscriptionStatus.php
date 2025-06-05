<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Enum;

/**
 * Class SubscriptionStatus
 *
 * @package App\Modules\AdSpy\Enum
 */
enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case PAUSED = 'paused';
    case DISABLED = 'disabled';
}
