<?php declare(strict_types=1);

namespace App\Modules\AdSpy\ValueObject;

use App\Modules\AdSpy\Exception\InvalidTitleFormatException;
use Illuminate\Support\Str;
use Stringable;

/**
 * Class Title
 *
 * @package App\ValueObject
 */
class Title implements Stringable
{
    private string $value;

    /**
     * @param string $title
     * @throws InvalidTitleFormatException
     */
    public function __construct(
        string $title
    ) {
        $this->value = $this->validatedValue($title);
    }

    /**
     * @param string $title
     * @return static
     * @throws InvalidTitleFormatException
     */
    public static function make(string $title): Title
    {
        return new static($title);
    }

    /**
     * @throws InvalidTitleFormatException
     */
    private function validatedValue(string $title): string
    {
        $title = trim($title);
        if (empty($title)) {
            throw new InvalidTitleFormatException('Title must be not empty string');
        }

        return Str::title($title);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
