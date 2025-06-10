<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Provider;

use App\Interface\CommandBus\CommandBusInterface;
use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\Adapter\UserAdapter;
use App\Modules\AdSpy\Client\AdvertClient;
use App\Modules\AdSpy\CommandBus\Command\Advert\DeleteAdvert;
use App\Modules\AdSpy\CommandBus\Command\Advert\StoreAdvert;
use App\Modules\AdSpy\CommandBus\Command\Advert\UpdateAdvert;
use App\Modules\AdSpy\CommandBus\Command\Price\BulkInsertPrice;
use App\Modules\AdSpy\CommandBus\Command\Price\DeletePricesByAdvertId;
use App\Modules\AdSpy\CommandBus\Command\Price\StorePrice;
use App\Modules\AdSpy\CommandBus\Command\Subscription\DeleteSubscription;
use App\Modules\AdSpy\CommandBus\Command\Subscription\StoreSubscription;
use App\Modules\AdSpy\CommandBus\Command\Subscription\ToggleSubscriptionStatus;
use App\Modules\AdSpy\CommandBus\Command\Subscription\UpdateSubscription;
use App\Modules\AdSpy\CommandBus\CommandHandler\Advert\DeleteAdvertHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Advert\StoreAdvertHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Advert\UpdateAdvertHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Price\BulkInsertPriceHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Price\DeletePricesByAdvertIdHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Price\StorePriceHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\DeleteSubscriptionHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\StoreSubscriptionHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\ToggleSubscriptionStatusHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\UpdateSubscriptionHandler;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Event\AdvertsPricesCheckFinished;
use App\Modules\AdSpy\Event\NewPricesInsertionFinished;
use App\Modules\AdSpy\GateWay\AdSpyGateWay;
use App\Modules\AdSpy\Interface\Adapter\UserAdapterInterface;
use App\Modules\AdSpy\Interface\AdSpyGateWayInterface;
use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use App\Modules\AdSpy\Interface\AdvertPageParserInterface;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;
use App\Modules\AdSpy\Listener\InsertNewPrices;
use App\Modules\AdSpy\Listener\SendNewPriceMail;
use App\Modules\AdSpy\Observer\AdvertObserver;
use App\Modules\AdSpy\Observer\SubscriptionObserver;
use App\Modules\AdSpy\QueryBus\Query\Advert\FetchLastAdvertId;
use App\Modules\AdSpy\QueryBus\Query\Advert\FetchPricesByAdvertsIds;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertById;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertByUrl;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForAdvert;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForSubscription;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchAllUserSubscriptions;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchSubscribersIdsByAdvertId;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindSubscriptionById;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindUserSubscriptionByAdvertId;
use App\Modules\AdSpy\QueryBus\QueryHandler\Advert\FetchLastAdvertIdHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Advert\FetchPricesByAdvertsIdsHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Advert\FindAdvertByIdHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Advert\FindAdvertByUrlHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Price\FetchPriceHistoryForAdvertHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Price\FetchPriceHistoryForSubscriptionHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FetchAllUserSubscriptionsHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FetchSubscribersIdsByAdvertIdHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FindSubscriptionByIdHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FindUserSubscriptionByAdvertIdHandler;
use App\Modules\AdSpy\Repository\Advert\ReadAdvertRepository;
use App\Modules\AdSpy\Repository\Advert\WriteAdvertRepository;
use App\Modules\AdSpy\Repository\Price\ReadPriceRepository;
use App\Modules\AdSpy\Repository\Price\WritePriceRepository;
use App\Modules\AdSpy\Repository\Subscription\ReadSubscriptionRepository;
use App\Modules\AdSpy\Repository\Subscription\WriteSubscriptionRepository;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertDataFetcher;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertPageParser;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdSpyServiceProvider
 *
 * @package App\Modules\AdSpy\Provider
 */
class AdSpyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ReadAdvertRepositoryInterface::class, ReadAdvertRepository::class);
        $this->app->singleton(WriteAdvertRepositoryInterface::class, WriteAdvertRepository::class);

        $this->app->singleton(ReadPriceRepositoryInterface::class, ReadPriceRepository::class);
        $this->app->singleton(WritePriceRepositoryInterface::class, WritePriceRepository::class);

        $this->app->singleton(ReadSubscriptionRepositoryInterface::class, ReadSubscriptionRepository::class);
        $this->app->singleton(WriteSubscriptionRepositoryInterface::class, WriteSubscriptionRepository::class);

        $this->app->singleton(AdSpyGateWayInterface::class, AdSpyGateWay::class);
        $this->app->singleton(UserAdapterInterface::class, UserAdapter::class);

        $this->app->bind(AdvertClientInterface::class, AdvertClient::class);
        $this->app->bind(AdvertDataFetcherInterface::class, AdvertDataFetcher::class);
        $this->app->bind(AdvertPageParserInterface::class, AdvertPageParser::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(AdvertsPricesCheckFinished::class, InsertNewPrices::class);
        Event::listen(NewPricesInsertionFinished::class, SendNewPriceMail::class);

        $commandBus = app(CommandBusInterface::class);

        $commandBus->register([
            StoreAdvert::class => StoreAdvertHandler::class,
            UpdateAdvert::class => UpdateAdvertHandler::class,
            DeleteAdvert::class => DeleteAdvertHandler::class,

            StorePrice::class => StorePriceHandler::class,

            StoreSubscription::class => StoreSubscriptionHandler::class,
            UpdateSubscription::class => UpdateSubscriptionHandler::class,
            DeleteSubscription::class => DeleteSubscriptionHandler::class,
            ToggleSubscriptionStatus::class => ToggleSubscriptionStatusHandler::class,
        ]);

        $queryBus = app(QueryBusInterface::class);

        $queryBus->register([
            FindAdvertById::class => FindAdvertByIdHandler::class,
            FindAdvertByUrl::class => FindAdvertByUrlHandler::class,
            FetchLastAdvertId::class => FetchLastAdvertIdHandler::class,
            FetchPricesByAdvertsIds::class => FetchPricesByAdvertsIdsHandler::class,

            FetchPriceHistoryForAdvert::class => FetchPriceHistoryForAdvertHandler::class,
            FetchPriceHistoryForSubscription::class => FetchPriceHistoryForSubscriptionHandler::class,
            DeletePricesByAdvertId::class => DeletePricesByAdvertIdHandler::class,
            BulkInsertPrice::class => BulkInsertPriceHandler::class,

            FetchAllUserSubscriptions::class => FetchAllUserSubscriptionsHandler::class,
            FindSubscriptionById::class => FindSubscriptionByIdHandler::class,
            FindUserSubscriptionByAdvertId::class => FindUserSubscriptionByAdvertIdHandler::class,
            FetchSubscribersIdsByAdvertId::class => FetchSubscribersIdsByAdvertIdHandler::class
        ]);

        Subscription::observe(SubscriptionObserver::class);
        Advert::observe(AdvertObserver::class);
    }
}
