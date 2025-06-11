<?php

namespace App\Modules\AdSpy\Queue\Job\Mail;

use Bus;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Log;
use Throwable;

class SendNewPriceMailJobDispatcherJob implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $batchId
     * @param array<SendNewPriceMailJob> $sendMailJobs
     */
    public function __construct(
        private readonly string $batchId,
        private readonly array $sendMailJobs,
    ) {
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        Bus::batch($this->sendMailJobs)
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error($e->getMessage() . " Batch: $this->batchId", $e->getTrace());
            })->onQueue('mail')->dispatch();
    }
}
