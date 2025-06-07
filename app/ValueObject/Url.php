<?php declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\InvalidUrlFormatException;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\UriInterface;
use Stringable;

/**
 * Class Url
 *
 * @package App\ValueObject
 */
class Url implements Stringable
{
    private string $value;

    /**
     * @param string $url
     * @throws InvalidUrlFormatException
     */
    public function __construct(
        string $url
    ) {
        $this->value = $this->validatedValue($url);
    }

    /**
     * @param string $url
     * @return string
     * @throws InvalidUrlFormatException
     */
    private function validatedValue(string $url): string
    {
        $url = trim($url);
        if (empty($url)) {
            throw new InvalidUrlFormatException('Url must be not empty string');
        }

        $pattern = "#^(?<url>[(http(s)?)://(www\.)?a-zA-Z0-9@:%._+~\#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~\#?&=/]*))$#";
        preg_match_all($pattern, $url, $matches, PREG_UNMATCHED_AS_NULL);

        if ($matches['url'] === null) {
            throw new InvalidUrlFormatException('Invalid url format');
        }

        return $url;
    }

    /**
     * @param string $email
     * @return Url
     * @throws InvalidUrlFormatException
     */
    public static function make(string $email): Url
    {
        return new static($email);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return UriInterface
     */
    public function uri(): UriInterface
    {
        return Utils::uriFor($this->value());
    }

    public function __toString()
    {
        return $this->value();
    }
}
