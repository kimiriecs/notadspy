<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Dispatcher;

use App\Modules\AdSpy\Queue\Job\StarterJob;
use Bus;

/**
 * Class StarterJobDispatcher
 *
 * @package App\Modules\AdSpy\Queue\Dispatcher
 */
class StarterJobDispatcher
{
    /**
     * @param StarterJob[] $jobs
     * @return void
     */
    public function dispatch(array $jobs): void
    {
        Bus::chain($jobs)->onQueue('starter')->dispatch();
    }
}
