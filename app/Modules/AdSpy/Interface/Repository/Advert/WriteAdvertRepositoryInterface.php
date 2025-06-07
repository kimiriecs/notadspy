<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Advert;

use App\Interface\Repository\WriteRepositoryInterface;
use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Entities\Advert;
use App\ValueObject\NotNegativeInteger;

/**
 * Interface WriteAdvertRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Advert
 */
interface WriteAdvertRepositoryInterface extends WriteRepositoryInterface
{
    /**
     * @param AdvertData $advert
     * @return Advert
     */
    public function store(AdvertData $advert): Advert;

    /**
     * @param NotNegativeInteger $advertId
     * @param AdvertData $advert
     * @return Advert
     */
    public function update(NotNegativeInteger $advertId, AdvertData $advert): Advert;
}
