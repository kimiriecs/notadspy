<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Advert;

use App\Bus\CommandBus\Command;
use App\ValueObject\NotNegativeInteger;

/**
 * Class DeleteAdvert
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Advert
 */
class DeleteAdvert extends Command
{
    /**
     * @param NotNegativeInteger $advertId
     */
    public function __construct(private NotNegativeInteger $advertId)
    {
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }
}
