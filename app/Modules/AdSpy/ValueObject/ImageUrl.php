<?php declare(strict_types=1);

namespace App\Modules\AdSpy\ValueObject;

use App\Modules\AdSpy\Exception\InvalidTitleFormatException;
use App\Modules\AdSpy\Exception\InvalidUrlFormatException;
use Illuminate\Support\Str;
use Stringable;

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
