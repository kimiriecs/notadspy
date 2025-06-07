<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Cache\RedisStorage;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;

/**
 * Class MailCacheStorage
 *
 * @package App\Modules\AdSpy\Cache\RedisStorage
 */
readonly class MailCacheStorage extends BaseCacheStorage
{
    private const string BASE_KEY = "advert.mails.batch";

    /**
     * @param string $batchId
     * @param NewPriceMailData $data
     * @return bool
     */
    public function addMail(string $batchId, NewPriceMailData $data): bool
    {
        return $this->addToTable($this->tableName($batchId), $data->getAdvertId()->asInt(), $data);
    }

    /**
     * @param string $batchId
     * @return array<NewPriceMailData>
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     */
    public function getAllMails(string $batchId): array
    {
        $mails = $this->getAllFromTable($this->tableName($batchId));

        return array_map(function (string $mail) {
            return NewPriceMailData::fromJson($mail);
        }, $mails);
    }

    /**
     * @param string $batchId
     * @return string
     */
    public function getMailsBatchTable(string $batchId): string
    {
        return $this->tableName($batchId);
    }

    /**
     * @param string $batchId
     * @return bool
     */
    public function deleteMailsBatchTable(string $batchId): bool
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
