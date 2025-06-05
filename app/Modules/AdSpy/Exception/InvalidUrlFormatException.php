<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidUrlFormatException
 *
 * @package App\Exception
 */
class InvalidUrlFormatException extends Exception implements CustomExceptionInterface
{

}
