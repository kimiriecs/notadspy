<?php declare(strict_types=1);

namespace App\Modules\AdSpy\ValueObject;

use App\Modules\AdSpy\Enum\CurrencySymbol;
use App\Modules\AdSpy\Exception\InvalidCurrencyFormatException;
use Stringable;

/**
 * Class Currency
 *
 * @package App\ValueObject
 */
class Currency implements Stringable
{
    private string $value;

    /**
     * @param string $currency
     * @throws InvalidCurrencyFormatException
     */
    public function __construct(
        string $currency
    ) {
        $this->value = $this->validatedValue($currency);
    }

    /**
     * @param string $currency
     * @return string
     * @throws InvalidCurrencyFormatException
     */
    private function validatedValue(string $currency): string
    {
        $currency = trim($currency);
        if (empty($currency)) {
            throw new InvalidCurrencyFormatException('Currency must be not empty string');
        }

        $pattern = '/(?<currency>^[a-zA-Z]{3}$)/';
        preg_match_all($pattern, $currency, $matches, PREG_UNMATCHED_AS_NULL);

        if ($matches['currency'] === null) {
            throw new InvalidCurrencyFormatException('Invalid currency format');
        }

        return strtoupper($currency);
    }

    /**
     * @param string $currency
     * @return Currency
     * @throws InvalidCurrencyFormatException
     */
    public static function make(string $currency): Currency
    {
        return new self($currency);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function asSymbol(): string
    {
        return CurrencySymbol::tryFrom($this->value())->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
