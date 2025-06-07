<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Dto;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\ValueObject\Currency;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Price;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use JsonSerializable;

/**
 * Class AdvertFetchedData
 *
 * @package App\Modules\AdSpy\Dto
 */
readonly class PriceData implements JsonSerializable, Jsonable
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
     * @return PriceData
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public static function fromJson(string $data, bool $associative = true): PriceData
    {
        $arrayData = json_decode($data, $associative);

        return self::fromArray($arrayData);
    }

    /**
     * @param array $data
     * @return PriceData
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public static function fromArray(array $data): PriceData
    {
        $amount = $data['amount'] ?? null;
        $currency = $data['currency'] ?? null;
        $advertId = $data['advert_id'] ?? null;
        $id = $data['id'] ?? null;

        if (empty($advertId) ||
            empty($amount) ||
            empty($currency)
        ) {
            throw new InvalidArgumentException("Unable to create Price object with provided arguments: some of arguments are empty");
        }

        return new self(
            price: Price::fromArray([
                'amount' => $amount,
                'currency' => $currency,
            ]),
            advertId: NotNegativeInteger::fromNumber($advertId),
            id: !empty($id) ? NotNegativeInteger::fromNumber($id) : null,
        );
    }
}
