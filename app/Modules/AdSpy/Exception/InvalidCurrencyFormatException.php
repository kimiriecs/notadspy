<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidCurrencyFormatException
 *
 * @package App\Exception
 */
class InvalidCurrencyFormatException extends Exception implements CustomExceptionInterface
{

}
