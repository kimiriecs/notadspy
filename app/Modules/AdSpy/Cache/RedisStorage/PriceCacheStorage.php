<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Cache\RedisStorage;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Dto\PriceData;

/**
 * Class PriceCacheStorage
 *
 * @package App\Modules\AdSpy\Cache\RedisStorage
 */
readonly class PriceCacheStorage extends BaseCacheStorage
{
    private const string BASE_KEY = "advert.prices.batch";

    /**
     * @param string $batchId
     * @param PriceData $data
     * @return bool
     */
    public function addPrice(string $batchId, PriceData $data): bool
    {
        return $this->addToTable($this->tableName($batchId), $data->getAdvertId()->asInt(), $data);
    }

    /**
     * @param string $batchId
     * @return array<PriceData>
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public function getAllPrices(string $batchId): array
    {
        $prices = $this->getAllFromTable($this->tableName($batchId));

        return array_map(function (string $price) {
            return PriceData::fromJson($price);
        }, $prices);
    }

    /**
     * @param string $batchId
     * @return string
     */
    public function getPricesBatchTable(string $batchId): string
    {
        return $this->tableName($batchId);
    }

    /**
     * @param string $batchId
     * @return bool
     */
    public function deletePricesBatchTable(string $batchId): bool
    {
        return $this->delTable($this->tableName($batchId));
    }

    /**
     * @return string
     */
    protected function key(): string
    {
        return self::BASE_KEY;
    }
}
