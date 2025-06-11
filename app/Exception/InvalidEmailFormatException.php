<?php declare(strict_types=1);

namespace App\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidEmailFormatException
 *
 * @package App\Exception
 */
class InvalidEmailFormatException extends Exception implements CustomExceptionInterface
{

}
