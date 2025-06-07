<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Dispatcher\Mail;

use App\Modules\AdSpy\Cache\RedisStorage\MailCacheStorage;
use App\Modules\AdSpy\Cache\RedisStorage\PriceCacheStorage;
use App\Modules\AdSpy\Queue\Job\Mail\SendNewPriceMailJob;
use Bus;
use Illuminate\Bus\Batch;
use Log;
use Throwable;

/**
 * Class SendNewPriceMailJobDispatcher
 *
 * @package App\Modules\AdSpy\Queue\Dispatcher\Mail
 */
readonly class SendNewPriceMailJobDispatcher
{
    /**
     * @param SendNewPriceMailJob[] $sendMailJobs
     * @param string $initialBatchId
     * @return void
     * @throws Throwable
     */
    public function dispatchMany(array $sendMailJobs, string $initialBatchId): void
    {
        Bus::batch($sendMailJobs)->then(function (Batch $batch) use ($initialBatchId) {
            $priceStorage = app(PriceCacheStorage::class);
            $mailStorage = app(MailCacheStorage::class);
            $priceStorage->deletePricesBatchTable($initialBatchId);
            $mailStorage->deleteMailsBatchTable($initialBatchId);
            $priceStorage->deleteBatchTimeMark($initialBatchId);
        })->catch(function (Batch $batch, Throwable $e) {
            Log::error($e->getMessage() . " Batch: $batch->id", $e->getTrace());
        })->onQueue('new_price_mail_send')->dispatch();
    }
}
