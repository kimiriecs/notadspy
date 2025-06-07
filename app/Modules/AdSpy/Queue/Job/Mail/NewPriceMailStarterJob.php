<?php

namespace App\Modules\AdSpy\Queue\Job\Mail;

use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Queue\Dispatcher\Mail\NewPriceMailBatchJobDispatcher;
use App\Modules\AdSpy\Queue\Factory\Mail\NewPriceMailBatchJobFactory;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class NewPriceMailStarterJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * @param NewPriceMailData $mail
     * @param NotNegativeInteger[][] $subscribersIdsInChunks
     * @param string $initialBatchId
     */
    public function __construct(
        private readonly NewPriceMailData $mail,
        private readonly array $subscribersIdsInChunks,
        private readonly string $initialBatchId,
    ) {
    }

    /**
     * @param NewPriceMailBatchJobFactory $newPriceMailBatchJobFactory
     * @param NewPriceMailBatchJobDispatcher $newPriceMailBatchJobDispatcher
     * @return void
     * @throws Throwable
     */
    public function handle(
        NewPriceMailBatchJobFactory $newPriceMailBatchJobFactory,
        NewPriceMailBatchJobDispatcher $newPriceMailBatchJobDispatcher
    ): void {
        $newPriceMailBatchJobs = $newPriceMailBatchJobFactory->createMany(
            $this->mail,
            $this->subscribersIdsInChunks,
            $this->initialBatchId
        );
        $newPriceMailBatchJobDispatcher->dispatchMany($newPriceMailBatchJobs);
    }
}
