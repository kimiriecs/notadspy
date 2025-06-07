<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Factory\Mail;

use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Queue\Job\Mail\NewPriceMailBatchJob;
use App\ValueObject\NotNegativeInteger;

/**
 * Class NewPriceMailBatchJobFactory
 *
 * @package App\Modules\AdSpy\Queue\Factory\Mail
 */
readonly class NewPriceMailBatchJobFactory
{
    /**
     * @param NewPriceMailData $mail
     * @param NotNegativeInteger[][] $subscribersIdsChunks
     * @param string $initialBatchId
     * @return array
     */
    public function createMany(NewPriceMailData $mail, array $subscribersIdsChunks, string $initialBatchId): array
    {
        return array_map(
            function (array $chunk) use ($mail, $initialBatchId) {
                return new NewPriceMailBatchJob($mail, $chunk, $initialBatchId);
            },
            $subscribersIdsChunks
        );
    }
}
