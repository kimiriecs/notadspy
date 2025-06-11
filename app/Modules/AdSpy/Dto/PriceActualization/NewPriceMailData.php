<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Dto\PriceActualization;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\ValueObject\ImageUrl;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use JsonSerializable;

/**
 * Class NewPriceMailData
 *
 * @package App\Modules\AdSpy\Dto\PriceActualization
 */
readonly class NewPriceMailData implements JsonSerializable, Jsonable
{
    /**
     * @param NotNegativeInteger $advertId
     * @param Title $advertTitle
     * @param ImageUrl $advertImageUrl
     * @param Url $advertUrl
     * @param Price $oldPrice
     * @param Price $newPrice
     */
    public function __construct(
        private NotNegativeInteger $advertId,
        private Title $advertTitle,
        private ImageUrl $advertImageUrl,
        private Url $advertUrl,
        private Price $oldPrice,
        private Price $newPrice,
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
    public function getOldPrice(): Price
    {
        return $this->oldPrice;
    }

    /**
     * @return Price
     */
    public function getNewPrice(): Price
    {
        return $this->newPrice;
    }

    public function jsonSerialize(): array
    {
        return [
            'advert_id' => $this->getAdvertId()->asInt(),
            'advert_title' => $this->getAdvertTitle()->value(),
            'advert_image_url' => $this->getAdvertImageUrl()->value(),
            'advert_url' => $this->getAdvertUrl()->value(),
            'old_price' => $this->getOldPrice()->jsonSerialize(),
            'new_price' => $this->getNewPrice()->jsonSerialize(),
        ];
    }

    /**
     * @param $options
     * @return false|string
     */
    public function toJson($options = 0): false|string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @param string $data
     * @param bool $associative
     * @return NewPriceMailData
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     */
    public static function fromJson(string $data, bool $associative = true): NewPriceMailData
    {
        $arrayData = json_decode($data, $associative);

        return self::fromArray($arrayData);
    }

    /**
     * @param array $data
     * @return NewPriceMailData
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     */
    public static function fromArray(array $data): NewPriceMailData
    {
        $advertId = $data['advert_id'] ?? null;
        $advertTitle = $data['advert_title'] ?? null;
        $advertImageUrl = $data['advert_image_url'] ?? null;
        $advertUrl = $data['advert_url'] ?? null;
        $oldPrice = $data['old_price'] ?? null;
        $newPrice = $data['new_price'] ?? null;

        if (
            empty($advertId) ||
            empty($advertTitle) ||
            empty($advertImageUrl) ||
            empty($advertUrl) ||
            empty($oldPrice) ||
            empty($newPrice)
        ) {
            throw new InvalidArgumentException("Unable to create Price object with provided arguments: some of arguments are empty");
        }

        return new self(
            advertId: NotNegativeInteger::fromNumber($advertId),
            advertTitle: Title::make($advertTitle),
            advertImageUrl: ImageUrl::make($advertImageUrl),
            advertUrl: Url::make($advertUrl),
            oldPrice: Price::fromArray($oldPrice),
            newPrice: Price::fromArray($newPrice),
        );
    }
}
