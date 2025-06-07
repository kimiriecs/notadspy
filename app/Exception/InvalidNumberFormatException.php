<?php declare(strict_types=1);

namespace App\Exception;

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
