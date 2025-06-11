<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\Command\Price;

use App\Bus\CommandBus\Command;
use App\ValueObject\NotNegativeInteger;

/**
 * Class DeletePricesByAdvertId
 *
 * @package App\Modules\AdSpy\CommandBus\Command\Price
 */
class DeletePricesByAdvertId extends Command
{
    public function __construct(private readonly NotNegativeInteger $advertId)
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
