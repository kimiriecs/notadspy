<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Dispatcher\Mail;

use App\Modules\AdSpy\Queue\Job\Mail\NewPriceMailBatchJob;
use Bus;
use Illuminate\Bus\Batch;
use Log;
use Throwable;

/**
 * Class NewPriceMailBatchJobDispatcher
 *
 * @package App\Modules\AdSpy\Queue\Dispatcher\Mail
 */
class NewPriceMailBatchJobDispatcher
{
    /**
     * @param NewPriceMailBatchJob[] $mailBatchJobs
     * @return void
     * @throws Throwable
     */
    public function dispatchMany(array $mailBatchJobs): void
    {
        Bus::batch($mailBatchJobs)
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error($e->getMessage() . " Batch: $batch->id", $e->getTrace());
            })->onQueue('new_price_mail_batch')->dispatch();
    }
}
