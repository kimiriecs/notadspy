<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Enum;

/**
 * Enum AdvertClientResponseStatus
 *
 * @package App\Modules\AdSpy\Enum
 */
enum AdvertClientResponseStatus: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
