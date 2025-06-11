<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Dispatcher;

use App\Modules\AdSpy\Event\AdvertsPricesCheckFinished;
use App\Modules\AdSpy\Queue\Job\CheckAdvertPriceJob;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Log;
use Throwable;

/**
 * Class CheckAdvertPriceJobDispatcher
 *
 * @package App\Modules\AdSpy\UseCase
 */
class CheckAdvertPriceJobDispatcher
{
    /**
     * @param array<CheckAdvertPriceJob> $jobs
     * @return void
     * @throws Throwable
     */
    public function dispatchMany(array $jobs): void
    {
        Bus::batch($jobs)->then(function (Batch $batch) {
            AdvertsPricesCheckFinished::dispatch($batch->id);
        })->catch(function (Batch $batch, Throwable $e) {
            Log::error($e->getMessage() . " Batch: $batch->id", $e->getTrace());
        })->onQueue('price_check')->dispatch();
    }
}
