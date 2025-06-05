<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Advert;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\Dto\AdvertData;

/**
 * Class StoreAdvert
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Advert
 */
class StoreAdvert extends Command
{
    /**
     * @param AdvertData $data
     */
    public function __construct(private readonly AdvertData $data)
    {
    }

    /**
     * @return AdvertData
     */
    public function getData(): AdvertData
    {
        return $this->data;
    }
}
