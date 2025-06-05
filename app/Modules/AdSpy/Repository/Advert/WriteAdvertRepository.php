<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Advert;

use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Repository\BaseWriteRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

/**
 * Class WriteAdvertRepository
 *
 * @package App\Modules\AdSpy\Repository\Advert
 */
class WriteAdvertRepository extends BaseWriteRepository implements WriteAdvertRepositoryInterface
{
    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        return Advert::query();
    }

    /**
     * @param AdvertData $advert
     * @return Advert
     */
    public function store(AdvertData $advert): Advert
    {
        /** @var Advert $advert */
        $advert = $this->getBuilder()
            ->create(
                Arr::except($advert->jsonSerialize(), ['price'])
            );

        return $advert;
    }

    /**
     * @param NotNegativeInteger $advertId
     * @param AdvertData $advert
     * @return Advert
     */
    public function update(NotNegativeInteger $advertId, AdvertData $advert): Advert
    {
        /** @var Advert|null $advert */
        $existingAdvert = $this->getBuilder()->firstWhere('id', $advertId->asInt());
        if (!$existingAdvert instanceof Advert) {
            throw new ModelNotFoundException("Advert with provided ID = {${$advertId->asInt()}} not found");
        }

        $success = $existingAdvert->update($advert->jsonSerialize());
        if (!$success) {
            throw new ModelNotFoundException("Unable to update advert with provided ID = {${$advertId->asInt()}}");
        }

        return $existingAdvert;
    }
}
