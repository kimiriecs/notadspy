<?php declare(strict_types=1);

namespace App\Modules\AdSpy\ValueObject;

use App\Modules\AdSpy\Exception\InvalidNumberFormatException;
use Stringable;

/**
 * Class Price
 *
 * @package App\ValueObject
 */
class Price implements Stringable
{
    private NotNegativeInteger $amount;
    private Currency $currency;

    /**
     * @param int|string $amount
     * @param string $currency
     * @throws InvalidNumberFormatException
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
}
