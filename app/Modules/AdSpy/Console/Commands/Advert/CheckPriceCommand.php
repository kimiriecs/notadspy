<?php

namespace App\Modules\AdSpy\Console\Commands\Advert;

use App\Modules\AdSpy\UseCase\ActualizeAdvertsPricesProcessor;
use Illuminate\Console\Command;
use Log;
use Throwable;

class CheckPriceCommand extends Command
{
    /**
     * @param ActualizeAdvertsPricesProcessor $processor
     */
    public function __construct(
        private readonly ActualizeAdvertsPricesProcessor $processor,
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check adverts prices' updates";

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $this->processor->process();
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }
    }
}
