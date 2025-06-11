<?php declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use JsonSerializable;
use Stringable;

/**
 * Class Price
 *
 * @package App\ValueObject
 */
class Price implements Stringable, JsonSerializable, Jsonable
{
    private NotNegativeInteger $amount;
    private Currency $currency;

    /**
     * @param int|string $amount
     * @param string $currency
     * @throws InvalidNumberFormatException
     * @throws InvalidCurrencyFormatException
     */
    public function __construct(
        int|string $amount,
        string $currency,
    ) {
        $this->amount = new NotNegativeInteger($amount);
        $this->currency = Currency::make($currency);
    }

    /**
     * @return NotNegativeInteger
     */
    public function amount(): NotNegativeInteger
    {
        return $this->amount;
    }


    /**
     * @return Currency
     */
    public function currency(): Currency
    {
        return $this->currency;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->amount() . ' ' . $this->currency();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount()->asInt(),
            'currency' => $this->currency()->value(),
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
     * @param array $data
     * @return Price
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): Price
    {
        $amount = $data['amount'] ?? null;
        $currency = $data['currency'] ?? null;
        if (empty($amount) || empty($currency)) {
            throw new InvalidArgumentException("Unable to create Price object with provided arguments: 'amount' and 'currency' can not be empty");
        }

        return new self(
            amount: $amount,
            currency: $currency
        );
    }
}
