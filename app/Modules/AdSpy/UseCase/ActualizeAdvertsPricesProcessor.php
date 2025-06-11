<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Queue\Dispatcher\StarterJobDispatcher;
use App\Modules\AdSpy\Queue\Factory\StarterJobFactory;
use Throwable;

/**
 * Class ActualizeAdvertsPricesProcessor
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class ActualizeAdvertsPricesProcessor
{
    /**
     * @param FetchAdvertsIdsInChunks $advertIdsInChunks
     * @param StarterJobFactory $starterJobFactory
     * @param StarterJobDispatcher $starterJobDispatcher
     */
    public function __construct(
        private FetchAdvertsIdsInChunks $advertIdsInChunks,
        private StarterJobFactory $starterJobFactory,
        private StarterJobDispatcher $starterJobDispatcher,
    ) {
    }

    /**
     * @return void
     * @throws InvalidNumberFormatException
     * @throws Throwable
     */
    public function process(): void
    {
        $advertIdsChunks = $this->advertIdsInChunks->fetch();
        $starterJobs = $this->starterJobFactory->createMany($advertIdsChunks);
        $this->starterJobDispatcher->dispatch($starterJobs);
    }
}
