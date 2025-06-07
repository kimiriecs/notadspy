<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Dispatcher\Mail;

use App\Modules\AdSpy\Queue\Job\Mail\NewPriceMailStarterJob;
use Bus;
use Illuminate\Bus\Batch;
use Log;
use Throwable;

/**
 * Class NewPriceMailStarterJobDispatcher
 *
 * @package App\Modules\AdSpy\Queue\Dispatcher\Mail
 */
class NewPriceMailStarterJobDispatcher
{
    /**
     * @param NewPriceMailStarterJob[] $mailStarterJobs
     * @return void
     * @throws Throwable
     */
    public function dispatchMany(array $mailStarterJobs): void
    {
        Bus::batch($mailStarterJobs)
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error($e->getMessage() . " Batch: $batch->id", $e->getTrace());
            })->onQueue('new_price_mail_starter')->dispatch();
    }
}
