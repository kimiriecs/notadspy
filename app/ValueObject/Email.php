<?php declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\InvalidEmailFormatException;

/**
 * Class Email
 *
 * @package App\ValueObject
 */
class Email
{
    private string $value;

    /**
     * @param string $email
     * @throws InvalidEmailFormatException
     */
    public function __construct(
        string $email
    ) {
        $this->value = $this->validatedValue($email);
    }

    /**
     * @param string $email
     * @return static
     * @throws InvalidEmailFormatException
     */
    public static function make(string $email): Email
    {
        return new static($email);
    }

    /**
     * @throws InvalidEmailFormatException
     */
    private function validatedValue(string $email): string
    {
        $email = trim($email);
        if (empty($email)) {
            throw new InvalidEmailFormatException('Email must be not empty string');
        }

        $pattern = '/(?<email>^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$)/';
        preg_match_all($pattern, $email, $matches, PREG_UNMATCHED_AS_NULL);

        if ($matches['email'] === null) {
            throw new InvalidEmailFormatException('Invalid email format');
        }

        return $email;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
