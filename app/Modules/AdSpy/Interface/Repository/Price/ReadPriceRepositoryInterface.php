<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Price;

use App\Interface\Repository\ReadRepositoryInterface;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ReadPriceRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Price
 */
interface ReadPriceRepositoryInterface extends ReadRepositoryInterface
{
    /**
     * @param NotNegativeInteger $advertId
     * @return Collection<Price>
     */
    public function fetchHistoryForAdvert(NotNegativeInteger $advertId): Collection;

    /**
     * @param NotNegativeInteger $advertId
     * @param NotNegativeInteger $subscriptionId
     * @return Collection<Price>
     */
    public function fetchHistoryForSubscription(NotNegativeInteger $advertId, NotNegativeInteger $subscriptionId): Collection;
}
