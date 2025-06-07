<?php declare(strict_types=1);

namespace App\Modules\User\Provider;

use App\Interface\CommandBus\CommandBusInterface;
use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\User\Adapter\AdSpyAdapter;
use App\Modules\User\GateWay\UserGateWay;
use App\Modules\User\Interface\AdSpyAdapterInterface;
use App\Modules\User\Interface\ReadUserRepositoryInterface;
use App\Modules\User\Interface\UserGateWayInterface;
use App\Modules\User\QueryBus\Query\FetchUsersByIds;
use App\Modules\User\QueryBus\QueryHandler\FetchUsersByIdsHandler;
use App\Modules\User\Repository\ReadUserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class UserServiceProvider
 *
 * @package App\Modules\User\Provider
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReadUserRepositoryInterface::class, ReadUserRepository::class);

        $this->app->bind(UserGateWayInterface::class, UserGateWay::class);
        $this->app->bind(AdSpyAdapterInterface::class, AdSpyAdapter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $commandBus = app(CommandBusInterface::class);

        $commandBus->register([]);

        $queryBus = app(QueryBusInterface::class);

        $queryBus->register([
            FetchUsersByIds::class => FetchUsersByIdsHandler::class
        ]);
    }
}
