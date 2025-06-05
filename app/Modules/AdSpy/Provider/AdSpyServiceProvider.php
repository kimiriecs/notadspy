<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Provider;

use App\Modules\AdSpy\Client\AdvertClient;
use App\Modules\AdSpy\Interfaces\AdvertClientInterface;
use App\Modules\AdSpy\Interfaces\AdvertDataFetcherInterface;
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
        $this->app->bind(AdvertClientInterface::class, AdvertClient::class);
        $this->app->bind(AdvertDataFetcherInterface::class, AdvertDataFetcher::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
