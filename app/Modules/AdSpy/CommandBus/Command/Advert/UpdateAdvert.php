<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Advert;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\Dto\AdvertData;
use App\ValueObject\NotNegativeInteger;

/**
 * Class UpdateAdvert
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Advert
 */
class UpdateAdvert extends Command
{
    /**
     * @param NotNegativeInteger $advertId
     * @param AdvertData $data
     */
    public function __construct(
        private readonly NotNegativeInteger $advertId,
        private readonly AdvertData $data
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
     * @return AdvertData
     */
    public function getData(): AdvertData
    {
        return $this->data;
    }
}
