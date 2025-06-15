<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Advert;

use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;
use App\Repository\BaseWriteRepository;
use App\ValueObject\NotNegativeInteger;
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
        $advertId = $advertId->asInt();
        /** @var Advert|null $advert */
        $existingAdvert = $this->getBuilder()->firstWhere('id', $advertId);
        if (!$existingAdvert instanceof Advert) {
            throw new ModelNotFoundException("Advert with provided ID = $advertId not found");
        }

        $success = $existingAdvert->update($advert->jsonSerialize());
        if (!$success) {
            throw new ModelNotFoundException("Unable to update advert with provided ID = $advertId");
        }

        return $existingAdvert;
    }

    /**
     * @param NotNegativeInteger $id
     * @return bool
     */
    public function restore(NotNegativeInteger $id): bool
    {
        $id = $id->asInt();
        /** @var Advert|null $model */
        $model = Advert::withTrashed()->firstWhere('id', $id);
        if (!$model) {
            throw new ModelNotFoundException("Advert with provided ID = $id not found");
        }

        $success = $model->restore();
        if (!$success) {
            throw new ModelNotFoundException("Unable to restore advert with provided ID = $id");
        }

        return $success;
    }
}
