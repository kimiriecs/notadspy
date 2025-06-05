<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class AdvertParsingException
 *
 * @package App\Exception
 */
class AdvertParsingException extends Exception implements CustomExceptionInterface
{

}
