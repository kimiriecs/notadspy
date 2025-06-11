<?php

namespace App\Modules\AdSpy\Queue\Job\Mail;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Interface\Adapter\UserAdapterInterface;
use App\Modules\AdSpy\Queue\Dispatcher\Mail\SendNewPriceMailJobDispatcher;
use App\Modules\AdSpy\Queue\Factory\Mail\SendNewPriceMailJobFactory;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class NewPriceMailBatchJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * @param NewPriceMailData $mail
     * @param NotNegativeInteger[] $subscribersIds
     * @param string $initialBatchId
     */
    public function __construct(
        private readonly NewPriceMailData $mail,
        private readonly array $subscribersIds,
        private readonly string $initialBatchId,
    ) {
    }

    /**
     * @param UserAdapterInterface $userAdapter
     * @param SendNewPriceMailJobFactory $sendNewPriceMailJobFactory
     * @param SendNewPriceMailJobDispatcher $sendNewPriceMailJobDispatcher
     * @return void
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     * @throws Throwable
     */
    public function handle(
        UserAdapterInterface $userAdapter,
        SendNewPriceMailJobFactory $sendNewPriceMailJobFactory,
        SendNewPriceMailJobDispatcher $sendNewPriceMailJobDispatcher
    ): void {
        $subscribers = $userAdapter->fetchUsersByIds($this->subscribersIds);
        $sendNewPriceMailJobs = $sendNewPriceMailJobFactory->createMany($this->mail, $subscribers);
        $sendNewPriceMailJobDispatcher->dispatchMany($sendNewPriceMailJobs, $this->initialBatchId);
    }
}
