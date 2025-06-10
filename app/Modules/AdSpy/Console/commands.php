<?php declare(strict_types=1);

use App\Modules\AdSpy\Console\Commands\Advert\CheckPriceCommand;
use App\Modules\AdSpy\Enum\TimeZone;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CheckPriceCommand::class)
    ->cron(config('scheduler.price_tracking_schedule'))
    ->timezone(TimeZone::KYIV->value);
