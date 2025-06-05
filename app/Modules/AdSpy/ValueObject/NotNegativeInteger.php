<?php declare(strict_types=1);

namespace App\Modules\AdSpy\ValueObject;

use App\Modules\AdSpy\Exception\InvalidNumberFormatException;
use Stringable;

/**
 * Class NotNegativeInteger
 *
 * @package App\ValueObject
 */
class NotNegativeInteger implements Stringable
{
    private string $value;

    /**
     * @param int|string $value
     * @throws InvalidNumberFormatException
     */
    public function __construct(
        int|string $value,
    ) {
        $this->value = $this->validatedValue($value);
    }

    /**
     * @param int $value
     * @return NotNegativeInteger
     * @throws InvalidNumberFormatException
     */
    public static function fromNumber(int $value): NotNegativeInteger
    {
        return new self($value);
    }

    /**
     * @param string $value
     * @return NotNegativeInteger
     * @throws InvalidNumberFormatException
     */
    public static function fromString(string $value): NotNegativeInteger
    {
        return new self($value);
    }

    /**
     * @param int|float|string $value
     * @return string
     * @throws InvalidNumberFormatException
     */
    private function validatedValue(int|float|string $value): string
    {
        if (!is_numeric($value)) {
            throw new InvalidNumberFormatException('Invalid argument: expected numeric value');
        }

        if (is_int($value) || is_float($value)) {
            return $this->validatedNumber($value);
        }

        return $this->validatedString($value);
    }

    /**
     * @param int|float $value
     * @return string
     * @throws InvalidNumberFormatException
     */
    private function validatedNumber(int|float $value): string
    {
        if ($value < 0) {
            throw new InvalidNumberFormatException
            ('Invalid argument: expected non-negative number');
        }

        return (string) $value;
    }

    /**
     * @param string $value
     * @return string
     * @throws InvalidNumberFormatException
     */
    private function validatedString(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidNumberFormatException
            ('Invalid argument format: expected not empty string');
        }

        preg_match(
            "/^-.*/",
            $value,
            $matches,
            PREG_UNMATCHED_AS_NULL
        );

        if (!empty($matches)) {
            throw new InvalidNumberFormatException('Invalid argument format: expected a positive number');
        }

        $this->validateNumberFormat($value);

        return $value;
    }

    /**
     * @param string $value
     * @return void
     * @throws InvalidNumberFormatException
     */
    protected function validateNumberFormat(string $value): void
    {
        preg_match(
            "/^\d+$/",
            $value,
            $matches,
            PREG_UNMATCHED_AS_NULL
        );

        if (empty($matches)) {
            throw new InvalidNumberFormatException('Invalid number format');
        }
    }

    /**
     * @return int
     */
    public function asInt(): int
    {
        return (int) $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
