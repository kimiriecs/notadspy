<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface;

use App\Modules\AdSpy\ValueObject\Url;
use Illuminate\Http\Response;

/**
 * Interface AdvertClientInterface
 *
 * @package App\Modules\AdSpy\Interface
 */
interface AdvertClientInterface
{
    /**
     * @param Url $url
     * @return Response
     */
    public function get(Url $url): Response;
}
