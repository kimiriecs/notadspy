<?php

namespace App\Modules\AdSpy\Queue\Job\Mail;

use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Mail\PriceSubscriptionMail;
use App\Modules\User\Entities\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;

class SendNewPriceMailJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * @param NewPriceMailData $mailData
     * @param User $subscriber
     */
    public function __construct(
        private readonly NewPriceMailData $mailData,
        private readonly User $subscriber,
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $mailable = new PriceSubscriptionMail($this->subscriber, $this->mailData);
        $recipient = new Address($this->subscriber->email, $this->subscriber->name);
        Mail::to($recipient)->send($mailable);
    }
}
