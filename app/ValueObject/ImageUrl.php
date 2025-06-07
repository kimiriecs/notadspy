<?php declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\InvalidUrlFormatException;

/**
 * Class ImageUrl
 *
 * @package App\Modules\AdSpy\ValueObject
 */
class ImageUrl extends Url
{
    /**
     * @param string $email
     * @return ImageUrl
     * @throws InvalidUrlFormatException
     */
    public static function make(string $email): ImageUrl
    {
        return new static($email);
    }
}
