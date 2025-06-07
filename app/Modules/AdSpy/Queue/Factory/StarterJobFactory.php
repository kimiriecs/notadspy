<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Factory;

use App\Modules\AdSpy\Queue\Job\StarterJob;
use App\ValueObject\NotNegativeInteger;

/**
 * Class StarterJobFactory
 *
 * @package App\Modules\AdSpy\Queue\Factory
 */
readonly class StarterJobFactory
{
    /**
     * @param NotNegativeInteger[][] $advertIds
     * @return StarterJob[]
     */
    public function createMany(array $advertIds): array
    {
        return array_map(
            function (array $chunk) {
                return new StarterJob($chunk);
            },
            $advertIds
        );
    }
}
