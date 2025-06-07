<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Factory\Mail;

use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Queue\Job\Mail\SendNewPriceMailJob;
use App\Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SendNewPriceMailJobFactory
 *
 * @package App\Modules\AdSpy\Queue\Factory
 */
readonly class SendNewPriceMailJobFactory
{
    /**
     * @param NewPriceMailData $mail
     * @param Collection $subscribers
     * @return array
     */
    public function createMany(NewPriceMailData $mail, Collection $subscribers): array
    {
        return $subscribers->map(
            function (User $subscriber) use ($mail) {
                return new SendNewPriceMailJob($mail, $subscriber);
            }
        )->toArray();
    }
}
