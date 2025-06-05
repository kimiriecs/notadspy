<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Enum;

/**
 * Enum AdvertSelector
 *
 * @package App\Modules\AdSpy\Enum
 */
enum AdvertSelector: string
{
    case TITLE = 'div[data-testid = "offer_title"] > h4';
    case IMAGE = 'div[data-testid = "ad-photo"] > div > img';
    case PRICE = 'div[data-testid = "ad-price-container"] > h3';
    case DATE = 'span[data-testid = "ad-posted-at"]';
}
