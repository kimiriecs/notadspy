<?php

namespace App\Modules\AdSpy\Listener;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Cache\RedisStorage\PriceCacheStorage;
use App\Modules\AdSpy\Event\AdvertsPricesCheckFinished;
use App\Modules\AdSpy\Event\Event;
use App\Modules\AdSpy\Queue\Factory\AddNewAdvertPriceJobFactory;
use Log;

readonly class InsertNewPrices
{
    /**
     * @param PriceCacheStorage $priceCacheStorage
     * @param AddNewAdvertPriceJobFactory $jobFactory
     */
    public function __construct(
        private PriceCacheStorage $priceCacheStorage,
        private AddNewAdvertPriceJobFactory $jobFactory
    ) {
    }

    /**
     * @param AdvertsPricesCheckFinished $event
     * @return void
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public function handle(Event $event): void
    {
        $batchId = $event->getBatchId();
        $newPrices = $this->priceCacheStorage->getAllPrices($batchId);
        if (empty($newPrices)) {
            Log::info("No prices for update. BatchID: $batchId");
            return;
        }
        $addNewPricesJob = $this->jobFactory->create($batchId);
        dispatch($addNewPricesJob);
    }
}
