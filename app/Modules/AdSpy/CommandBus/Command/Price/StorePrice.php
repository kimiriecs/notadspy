<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Price;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

/**
 * Class StorePrice
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Price
 */
class StorePrice extends Command
{
    /**
     * @param NotNegativeInteger $advertId
     * @param PriceData $priceData
     */
    public function __construct(
        private readonly NotNegativeInteger $advertId,
        private readonly PriceData $priceData
    ) {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }

    /**
     * @return PriceData
     */
    public function getPriceData(): PriceData
    {
        return $this->priceData;
    }
}
