<?php

namespace App\Modules\AdSpy\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdvertsPricesCheckFinished extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private readonly string $batchId)
    {
    }

    /**
     * @return string
     */
    public function getBatchId(): string
    {
        return $this->batchId;
    }
}
