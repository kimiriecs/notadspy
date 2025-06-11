<?php

namespace App\Modules\AdSpy\Mail;

use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\User\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param User $subscriber
     * @param NewPriceMailData $mailData
     */
    public function __construct(
        private readonly User $subscriber,
        private readonly NewPriceMailData $mailData
    ) {
        //
    }

    /**
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: new Address($this->subscriber->email, $this->subscriber->name),
            subject: 'Price Subscription Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mail',
            with: [
                'subscriber' => $this->subscriber->name,
                'oldPrice' => (string) $this->mailData->getOldPrice(),
                'newPrice' => (string) $this->mailData->getNewPrice(),
                'advertTitle' => $this->mailData->getAdvertTitle()->value(),
                'advertUrl' => $this->mailData->getAdvertUrl()->value(),
                'advertImageUrl' => $this->mailData->getAdvertImageUrl()->value(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
