<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Provider;

use App\Interface\CommandBus\CommandBusInterface;
use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\Client\AdvertClient;
use App\Modules\AdSpy\CommandBus\Command\Advert\DeleteAdvert;
use App\Modules\AdSpy\CommandBus\Command\Advert\StoreAdvert;
use App\Modules\AdSpy\CommandBus\Command\Advert\UpdateAdvert;
use App\Modules\AdSpy\CommandBus\Command\Price\DeletePricesByAdvertId;
use App\Modules\AdSpy\CommandBus\Command\Price\StorePrice;
use App\Modules\AdSpy\CommandBus\Command\Subscription\DeleteSubscription;
use App\Modules\AdSpy\CommandBus\Command\Subscription\StoreSubscription;
use App\Modules\AdSpy\CommandBus\Command\Subscription\UpdateSubscription;
use App\Modules\AdSpy\CommandBus\CommandHandler\Advert\DeleteAdvertHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Advert\StoreAdvertHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Advert\UpdateAdvertHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Price\DeletePricesByAdvertIdHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Price\StorePriceHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\DeleteSubscriptionHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\StoreSubscriptionHandler;
use App\Modules\AdSpy\CommandBus\CommandHandler\Subscription\UpdateSubscriptionHandler;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Price\ReadPriceRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Price\WritePriceRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\ReadSubscriptionRepositoryInterface;
use App\Modules\AdSpy\Interface\Repository\Subscription\WriteSubscriptionRepositoryInterface;
use App\Modules\AdSpy\Observer\AdvertObserver;
use App\Modules\AdSpy\Observer\SubscriptionObserver;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertById;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertByUrl;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForAdvert;
use App\Modules\AdSpy\QueryBus\Query\Price\FetchPriceHistoryForSubscription;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FetchAllUserSubscriptions;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindSubscriptionById;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindSubscriptionByUrl;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindUserSubscriptionByAdvertId;
use App\Modules\AdSpy\QueryBus\QueryHandler\Advert\FindAdvertByIdHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Advert\FindAdvertByUrlHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Price\FetchPriceHistoryForAdvertHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Price\FetchPriceHistoryForSubscriptionHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FetchAllUserSubscriptionsHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FindSubscriptionByIdHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FindSubscriptionByUrlHandler;
use App\Modules\AdSpy\QueryBus\QueryHandler\Subscription\FindUserSubscriptionByAdvertIdHandler;
use App\Modules\AdSpy\Repository\Advert\ReadAdvertRepository;
use App\Modules\AdSpy\Repository\Advert\WriteAdvertRepository;
use App\Modules\AdSpy\Repository\Price\ReadPriceRepository;
use App\Modules\AdSpy\Repository\Price\WritePriceRepository;
use App\Modules\AdSpy\Repository\Subscription\ReadSubscriptionRepository;
use App\Modules\AdSpy\Repository\Subscription\WriteSubscriptionRepository;
use App\Modules\AdSpy\Services\AdvertDataFetch\AdvertDataFetcher;
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

        $this->app->bind(AdvertClientInterface::class, AdvertClient::class);
        $this->app->bind(AdvertDataFetcherInterface::class, AdvertDataFetcher::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $commandBus = app(CommandBusInterface::class);

        $commandBus->register([
            StoreAdvert::class => StoreAdvertHandler::class,
            UpdateAdvert::class => UpdateAdvertHandler::class,
            DeleteAdvert::class => DeleteAdvertHandler::class,

            StorePrice::class => StorePriceHandler::class,

            StoreSubscription::class => StoreSubscriptionHandler::class,
            UpdateSubscription::class => UpdateSubscriptionHandler::class,
            DeleteSubscription::class => DeleteSubscriptionHandler::class,
        ]);

        $queryBus = app(QueryBusInterface::class);

        $queryBus->register([
            FindAdvertById::class => FindAdvertByIdHandler::class,
            FindAdvertByUrl::class => FindAdvertByUrlHandler::class,

            FetchPriceHistoryForAdvert::class => FetchPriceHistoryForAdvertHandler::class,
            FetchPriceHistoryForSubscription::class => FetchPriceHistoryForSubscriptionHandler::class,
            DeletePricesByAdvertId::class => DeletePricesByAdvertIdHandler::class,

            FetchAllUserSubscriptions::class => FetchAllUserSubscriptionsHandler::class,
            FindSubscriptionById::class => FindSubscriptionByIdHandler::class,
            FindSubscriptionByUrl::class => FindSubscriptionByUrlHandler::class,
            FindUserSubscriptionByAdvertId::class => FindUserSubscriptionByAdvertIdHandler::class,
        ]);

        Subscription::observe(SubscriptionObserver::class);
        Advert::observe(AdvertObserver::class);
    }
}
