<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Enum;

/**
 * Enum AdvertUrlPart
 *
 * @package App\Modules\AdSpy\Enum
 */
enum AdvertUrlPart: string
{
    case BASE_URL = 'https://www.olx.ua';
    case PREFIX_SEGMENT = '/d';
    case UA_LOCALE_SEGMENT = '/uk/';
}
