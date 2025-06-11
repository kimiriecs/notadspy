<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Enum;

/**
 * Enum CheckPricesCacheStorageKey
 *
 * @package App\Modules\AdSpy\Enum
 */
enum CheckPricesCacheStorageKey: string
{
    case BATCH_START_TIME_MARK_KEY = 'check_price_batch_start_time';
}
