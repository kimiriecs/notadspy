<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidTitleFormatException
 *
 * @package App\Exception
 */
class InvalidTitleFormatException extends Exception implements CustomExceptionInterface
{

}
