<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Dto;

use App\Modules\AdSpy\ValueObject\Currency;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Modules\AdSpy\ValueObject\Price;
use JsonSerializable;

/**
 * Class AdvertFetchedData
 *
 * @package App\Modules\AdSpy\Dto
 */
readonly class PriceData implements JsonSerializable
{
    /**
     * @param Price $price
     * @param NotNegativeInteger|null $advertId
     * @param NotNegativeInteger|null $id
     */
    public function __construct(
        private Price $price,
        private ?NotNegativeInteger $advertId = null,
        private ?NotNegativeInteger $id = null
    ) {
    }

    /**
     * @return NotNegativeInteger|null
     */
    public function getId(): ?NotNegativeInteger
    {
        return $this->id;
    }

    /**
     * @return NotNegativeInteger|null
     */
    public function getAdvertId(): ?NotNegativeInteger
    {
        return $this->advertId;
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAmount(): NotNegativeInteger
    {
        return $this->price->amount();
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->price->currency();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId()?->asInt(),
            'advert_id' => $this->getAdvertId()?->asInt(),
            'amount' => $this->getAmount()->asInt(),
            'currency' => $this->getCurrency()->value(),
        ];
    }
}
