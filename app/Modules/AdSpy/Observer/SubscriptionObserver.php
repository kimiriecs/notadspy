<?php

namespace App\Modules\AdSpy\Observer;

use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\UseCase\DeleteAdvertWithoutSubscriptions;

readonly class SubscriptionObserver
{
    /**
     * @param DeleteAdvertWithoutSubscriptions $deleteAdvert
     */
    public function __construct(private DeleteAdvertWithoutSubscriptions $deleteAdvert)
    {
    }

    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "deleted" event.
     * @throws InvalidNumberFormatException
     */
    public function deleted(Subscription $subscription): void
    {
        $this->deleteAdvert->execute($subscription->advert);
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }
}
