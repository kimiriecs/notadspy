<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Dto\PriceActualization;

use App\ValueObject\ImageUrl;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;

/**
 * Class CheckAdvertPriceData
 *
 * @package App\Modules\AdSpy\Dto\PriceActualization
 */
readonly class CheckAdvertPriceData
{
    /**
     * @param NotNegativeInteger $advertId
     * @param Title $advertTitle
     * @param ImageUrl $advertImageUrl
     * @param Url $advertUrl
     * @param Price $existingPrice
     */
    public function __construct(
        private NotNegativeInteger $advertId,
        private Title $advertTitle,
        private ImageUrl $advertImageUrl,
        private Url $advertUrl,
        private Price $existingPrice,
    ) {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }

    /**
     * @return Title
     */
    public function getAdvertTitle(): Title
    {
        return $this->advertTitle;
    }

    /**
     * @return ImageUrl
     */
    public function getAdvertImageUrl(): ImageUrl
    {
        return $this->advertImageUrl;
    }

    /**
     * @return Url
     */
    public function getAdvertUrl(): Url
    {
        return $this->advertUrl;
    }

    /**
     * @return Price
     */
    public function getExistingPrice(): Price
    {
        return $this->existingPrice;
    }
}
