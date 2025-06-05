<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Advert;

use App\Interface\Repository\ReadRepositoryInterface;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\ValueObject\Url;

/**
 * Interface ReadAdvertRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Advert
 */
interface ReadAdvertRepositoryInterface extends ReadRepositoryInterface
{
    /**
     * @param Url $advertUrl
     * @return Advert|null
     */
    public function findByUrl(Url $advertUrl): ?Advert;
}
