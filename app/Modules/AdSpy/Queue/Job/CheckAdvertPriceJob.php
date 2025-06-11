<?php

namespace App\Modules\AdSpy\Queue\Job;

use App\Modules\AdSpy\Cache\RedisStorage\MailCacheStorage;
use App\Modules\AdSpy\Cache\RedisStorage\PriceCacheStorage;
use App\Modules\AdSpy\Dto\PriceActualization\CheckAdvertPriceData;
use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Enum\CheckPricesCacheStorageKey;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use DateInvalidTimeZoneException;
use DateMalformedStringException;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckAdvertPriceJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * @param CheckAdvertPriceData $data
     */
    public function __construct(
        private readonly CheckAdvertPriceData $data,
    ) {
    }

    /**
     * @param AdvertDataFetcherInterface $fetcher
     * @param PriceCacheStorage $priceStorage
     * @param MailCacheStorage $mailStorage
     * @return void
     * @throws DateInvalidTimeZoneException
     * @throws DateMalformedStringException
     */
    public function handle(
        AdvertDataFetcherInterface $fetcher,
        PriceCacheStorage $priceStorage,
        MailCacheStorage $mailStorage
    ): void {
        if ($this->batch()->cancelled()) {
            return;
        }

        $existingAdvertPrice = $this->data->getExistingPrice();
        $actualAdvertPrice = $fetcher->fetchPrice($this->data->getAdvertUrl());
        if ($existingAdvertPrice->amount()->asInt() === $actualAdvertPrice->amount()->asInt()) {
            return;
        }

        $newPrice = new PriceData(
            price: $actualAdvertPrice,
            advertId: $this->data->getAdvertId()
        );

        $newPriceMailData = new NewPriceMailData(
            advertId: $this->data->getAdvertId(),
            advertTitle: $this->data->getAdvertTitle(),
            advertImageUrl: $this->data->getAdvertImageUrl(),
            advertUrl: $this->data->getAdvertUrl(),
            oldPrice: $this->data->getExistingPrice(),
            newPrice: $actualAdvertPrice,
        );

        $timeMark = $priceStorage->getBatchTimeMark($this->batchId);
        if (empty($timeMark)) {
            $priceStorage->setBatchTimeMark($this->batchId);
        }

        $priceStorage->addPrice($this->batchId, $newPrice);
        $mailStorage->addMail($this->batchId, $newPriceMailData);
    }
}
