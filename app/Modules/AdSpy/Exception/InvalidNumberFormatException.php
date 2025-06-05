<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidNumberFormatException
 *
 * @package App\Exception
 */
class InvalidNumberFormatException extends Exception implements CustomExceptionInterface
{

}
