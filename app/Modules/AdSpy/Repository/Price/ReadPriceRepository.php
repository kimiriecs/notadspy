<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Price;

use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Repository\BaseReadRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ReadPriceRepository
 *
 * @package App\Modules\AdSpy\Repository\Price
 */
class ReadPriceRepository extends BaseReadRepository implements ReadPriceRepositoryInterface
{
    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        return Price::query();
    }

    /**
     * @param NotNegativeInteger $advertId
     * @return Collection<PriceData>
     */
    public function fetchHistoryForAdvert(NotNegativeInteger $advertId): Collection
    {
        return $this->getBuilder()
            ->with('advert')
            ->where('advert_id', $advertId->asInt())
            ->get();
    }

    /**
     * @param NotNegativeInteger $advertId
     * @param NotNegativeInteger $subscriptionId
     * @return Collection<Price>
     */
    public function fetchHistoryForSubscription(NotNegativeInteger $advertId, NotNegativeInteger $subscriptionId): Collection
    {
        return new Collection([]);
    }
}
