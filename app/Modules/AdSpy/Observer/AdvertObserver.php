<?php

namespace App\Modules\AdSpy\Observer;

use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\UseCase\DeleteAdvertPrices;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;

readonly class AdvertObserver
{
    public function __construct(private DeleteAdvertPrices $deleteAdvertPrices)
    {
    }

    /**
     * Handle the Advert "created" event.
     */
    public function created(Advert $subscription): void
    {
        //
    }

    /**
     * Handle the Advert "updated" event.
     */
    public function updated(Advert $subscription): void
    {
        //
    }

    /**
     * Handle the Advert "deleted" event.
     * @throws InvalidNumberFormatException
     */
    public function deleted(Advert $advert): void
    {
        $this->deleteAdvertPrices->execute(NotNegativeInteger::fromNumber($advert->id));
    }

    /**
     * Handle the Advert "restored" event.
     */
    public function restored(Advert $subscription): void
    {
        //
    }

    /**
     * Handle the Advert "force deleted" event.
     */
    public function forceDeleted(Advert $subscription): void
    {
        //
    }
}
