<?php

namespace App\Modules\AdSpy\Listener;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Cache\RedisStorage\MailCacheStorage;
use App\Modules\AdSpy\Event\Event;
use App\Modules\AdSpy\Queue\Dispatcher\Mail\NewPriceMailStarterJobDispatcher;
use App\Modules\AdSpy\Queue\Factory\Mail\NewPriceMailStarterJobFactory;
use Throwable;

readonly class SendNewPriceMail
{
    /**
     * @param MailCacheStorage $mailCacheStorage
     * @param NewPriceMailStarterJobFactory $mailStarterJobFactory
     * @param NewPriceMailStarterJobDispatcher $mailStarterJobDispatcher
     */
    public function __construct(
        private MailCacheStorage $mailCacheStorage,
        private NewPriceMailStarterJobFactory $mailStarterJobFactory,
        private NewPriceMailStarterJobDispatcher $mailStarterJobDispatcher
    ) {
    }

    /**
     * @param Event $event
     * @return void
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     * @throws Throwable
     */
    public function handle(Event $event): void
    {
        $initialBatchId = $event->getBatchId();
        $mails = $this->mailCacheStorage->getAllMails($initialBatchId);
        $mailStarterJobs = $this->mailStarterJobFactory->createMany($mails, $initialBatchId);
        $this->mailStarterJobDispatcher->dispatchMany($mailStarterJobs);
    }
}
