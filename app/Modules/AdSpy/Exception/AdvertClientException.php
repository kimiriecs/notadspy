<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Exception;

use App\Interface\CustomExceptionInterface;
use Exception;

/**
 * Class AdvertClientException
 *
 * @package App\Exception
 */
class AdvertClientException extends Exception implements CustomExceptionInterface
{

}
