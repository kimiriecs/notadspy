<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Price;

use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Enum\TimeZone;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;
use App\Repository\BaseWriteRepository;
use App\ValueObject\NotNegativeInteger;
use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTime;
use DateTimeZone;
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

    /**
     * @param array<PriceData> $prices
     * @return bool
     * @throws DateInvalidTimeZoneException
     * @throws DateMalformedStringException
     */
    public function bulkInsert(array $prices): bool
    {
        $newPrices = array_map(function(PriceData $price) {
            $priceData = $price->jsonSerialize();
            $now = new DateTime('now', new DateTimeZone(TimeZone::KYIV->value));
            $priceData['created_at'] = $now;
            $priceData['updated_at'] = $now;
            return $priceData;
        }, $prices);

        return $this->getBuilder()->insert($newPrices);
    }
}
