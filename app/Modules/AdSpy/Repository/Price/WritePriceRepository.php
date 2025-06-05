<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Price;

use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Repository\BaseWriteRepository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class WritePriceRepository
 *
 * @package App\Modules\AdSpy\Repository\Price
 */
class WritePriceRepository  extends BaseWriteRepository implements WritePriceRepositoryInterface
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
     * @param PriceData $price
     * @return Price
     */
    public function store(NotNegativeInteger $advertId, PriceData $price): Price
    {
        $data = $price->jsonSerialize();
        $data['advert_id'] = $advertId->asInt();

        /** @var Price $price */
        $price = $this->getBuilder()->create($data);

        return $price;
    }

    /**
     * @param NotNegativeInteger $advertId
     * @return bool
     */
    public function deletePricesByAdvertId(NotNegativeInteger $advertId): bool
    {
        return  (bool) $this->getBuilder()
            ->where('advert_id', $advertId->asInt())
            ->delete();
    }
}
