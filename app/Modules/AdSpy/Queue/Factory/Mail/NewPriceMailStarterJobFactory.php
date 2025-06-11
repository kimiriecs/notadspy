<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Factory\Mail;

use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Queue\Job\Mail\NewPriceMailStarterJob;
use App\Modules\AdSpy\UseCase\FetchAdvertsSubscribersIdsInChunks;

/**
 * Class NewPriceMailStarterJobFactory
 *
 * @package App\Modules\AdSpy\Queue\Factory\Mail
 */
readonly class NewPriceMailStarterJobFactory
{
    public function __construct(
        private FetchAdvertsSubscribersIdsInChunks $subscribersIdsInChunks
    ) {
    }

    /**
     * @param NewPriceMailData[] $mails
     * @param string $initialBatchId
     * @return NewPriceMailStarterJob[]
     */
    public function createMany(array $mails, string $initialBatchId): array
    {
        return array_map(
            function (NewPriceMailData $mail) use ($initialBatchId) {
                $subscribersIdsInChunks = $this->subscribersIdsInChunks->fetch($mail->getAdvertId());
                return new NewPriceMailStarterJob($mail, $subscribersIdsInChunks, $initialBatchId);
            },
            $mails
        );
    }
}
