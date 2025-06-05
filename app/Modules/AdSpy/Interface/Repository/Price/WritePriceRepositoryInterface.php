<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Price;

use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Interface WritePriceRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Price
 */
interface WritePriceRepositoryInterface
{
    /**
     * @param NotNegativeInteger $advertId
     * @param PriceData $price
     * @return Price
     */
    public function store(NotNegativeInteger $advertId, PriceData $price): Price;

    /**
     * @param NotNegativeInteger $advertId
     * @return bool
     */
    public function deletePricesByAdvertId(NotNegativeInteger $advertId): bool;
}
