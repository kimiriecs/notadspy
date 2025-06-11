<?php

namespace App\Modules\AdSpy\Queue\Job;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\QueryBus\Query\Advert\FetchPricesByAdvertsIds;
use App\Modules\AdSpy\Queue\Dispatcher\CheckAdvertPriceJobDispatcher;
use App\Modules\AdSpy\Queue\Factory\CheckAdvertPriceJobFactory;
use App\ValueObject\NotNegativeInteger;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class StarterJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * @param array<NotNegativeInteger> $advertIds
     */
    public function __construct(
        private readonly array $advertIds,
    ) {
    }

    /**
     * @param QueryBusInterface $queryBus
     * @param CheckAdvertPriceJobFactory $checkAdvertPriceJobFactory
     * @param CheckAdvertPriceJobDispatcher $checkAdvertPriceJobDispatcher
     * @return void
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     * @throws Throwable
     */
    public function handle(
        QueryBusInterface $queryBus,
        CheckAdvertPriceJobFactory $checkAdvertPriceJobFactory,
        CheckAdvertPriceJobDispatcher $checkAdvertPriceJobDispatcher
    ): void {
        $query = new FetchPricesByAdvertsIds($this->advertIds);
        /** @var Collection<Advert> $adverts */
        $adverts = $queryBus->dispatch($query);

        $checkAdvertsPricesJobs = $checkAdvertPriceJobFactory->createMany($adverts);
        $checkAdvertPriceJobDispatcher->dispatchMany($checkAdvertsPricesJobs);
    }
}
