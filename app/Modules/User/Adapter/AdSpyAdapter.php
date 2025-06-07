<?php declare(strict_types=1);

namespace App\Modules\User\Adapter;

use App\Modules\AdSpy\Interface\AdSpyGateWayInterface;
use App\Modules\User\Interface\AdSpyAdapterInterface;

/**
 * Class AdSpyAdapter
 *
 * @package App\Modules\User\Adapter
 */
readonly class AdSpyAdapter implements AdSpyAdapterInterface
{
    /**
     * @param AdSpyGateWayInterface $spyGateWay
     */
    public function __construct(
        private AdSpyGateWayInterface $spyGateWay
    ) {
    }
}
