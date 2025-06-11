<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Cache\RedisStorage;

use App\Modules\AdSpy\Enum\CheckPricesCacheStorageKey;
use App\Modules\AdSpy\Enum\TimeZone;
use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Redis;

/**
 * Class BaseCacheStorage
 *
 * @package App\Modules\AdSpy\Cache\RedisStorage
 */
abstract readonly class BaseCacheStorage
{
    /**
     * @param string $hashTableName
     * @param int|string $itemKey
     * @param Jsonable $itemData
     * @return bool
     */
    protected function addToTable(string $hashTableName, int|string $itemKey, Jsonable $itemData): bool
    {
        Redis::hset($hashTableName, $itemKey, $itemData->toJson());

        return true;
    }

    /**
     * @param string $hashTableName
     * @return bool
     */
    protected function delTable(string $hashTableName): bool
    {
        Redis::del($hashTableName);

        return true;
    }

    /**
     * @param string $hashTableName
     * @return array
     */
    protected function getAllFromTable(string $hashTableName): array
    {
        return Redis::hgetall($hashTableName);
    }

    /**
     * @return string
     */
    abstract protected function key(): string;

    /**
     * @param string $batchId
     * @return string
     */
    protected function tableName(string $batchId): string
    {
        $batchTimeMarkKey = $this->getBatchTimeMarkKey($batchId);
        $timeMark = $this->getTimeMark($batchTimeMarkKey);

        return "$timeMark.{$this->key()}.$batchId";
    }

    /**
     * @param string $batchId
     * @return string
     * @throws DateInvalidTimeZoneException
     * @throws DateMalformedStringException
     */
    public function setBatchTimeMark(string $batchId): string
    {
        $timeMarkKey = $this->getBatchTimeMarkKey($batchId);

        return $this->setTimeMark($timeMarkKey);
    }

    /**
     * @param string $batchId
     * @return string|null
     */
    public function getBatchTimeMark(string $batchId): ?string
    {
        $timeMarkKey = $this->getBatchTimeMarkKey($batchId);

        return $this->getTimeMark($timeMarkKey);
    }

    /**
     * @param string $batchId
     * @return bool
     */
    public function deleteBatchTimeMark(string $batchId): bool
    {
        $timeMarkKey = $this->getBatchTimeMarkKey($batchId);

        return $this->deleteTimeMark($timeMarkKey);
    }

    /**
     * @param string $key
     * @return string
     * @throws DateInvalidTimeZoneException
     * @throws DateMalformedStringException
     */
    private function setTimeMark(string $key): string
    {
        $timeMark = new DateTime('now', new DateTimeZone(TimeZone::KYIV->value))->format('Y_m_d_His');
        Redis::set($key, $timeMark);

        return $timeMark;
    }

    /**
     * @param string $timeMarkKey
     * @return string|null
     */
    private function getTimeMark(string $timeMarkKey): ?string
    {
        $timMark = Redis::get($timeMarkKey);

        return !empty($timMark) ? $timMark : null;
    }

    /**
     * @param string $timeMarkKey
     * @return bool
     */
    private function deleteTimeMark(string $timeMarkKey): bool
    {
        Redis::del($timeMarkKey);

        return true;
    }

    /**
     * @param string $batchId
     * @return string
     */
    private function getBatchTimeMarkKey(string $batchId): string
    {
        return CheckPricesCacheStorageKey::BATCH_START_TIME_MARK_KEY->value . "." . $batchId;
    }
}
