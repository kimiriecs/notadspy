<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Factory;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Cache\RedisStorage\PriceCacheStorage;
use App\Modules\AdSpy\Queue\Job\AddNewAdvertsPricesJob;

/**
 * Class AddNewAdvertPriceJobFactory
 *
 * @package App\Modules\AdSpy\Queue\Factory
 */
readonly class AddNewAdvertPriceJobFactory
{
    /**
     * @param PriceCacheStorage $priceCacheStorage
     */
    public function __construct(
        private PriceCacheStorage $priceCacheStorage
    ) {
    }

    /**
     * @param string $batchId
     * @return AddNewAdvertsPricesJob
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public function create(string $batchId): AddNewAdvertsPricesJob
    {
        $newPrices = $this->priceCacheStorage->getAllPrices($batchId);

        return new AddNewAdvertsPricesJob($batchId, $newPrices)->onQueue('new_price_insert');
    }
}
