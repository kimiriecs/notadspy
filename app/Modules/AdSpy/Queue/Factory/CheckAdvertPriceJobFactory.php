<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Queue\Factory;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Dto\PriceActualization\CheckAdvertPriceData;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Queue\Job\CheckAdvertPriceJob;
use App\ValueObject\ImageUrl;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CheckAdvertPriceJobFactory
 *
 * @package App\Modules\AdSpy\Jobs\Factory
 */
readonly class CheckAdvertPriceJobFactory
{
    /**
     * @param Collection<Advert> $adverts
     * @return array
     * @throws InvalidNumberFormatException
     * @throws InvalidUrlFormatException
     * @throws InvalidCurrencyFormatException
     * @throws InvalidTitleFormatException
     */
    public function createMany(Collection $adverts): array
    {
        $jobs = [];
        foreach ($adverts as $ad) {
            $priceData = new CheckAdvertPriceData(
                advertId: NotNegativeInteger::fromNumber($ad->id),
                advertTitle: Title::make($ad->title),
                advertImageUrl: ImageUrl::make($ad->image_url),
                advertUrl: Url::make($ad->url),
                existingPrice: new Price(
                    amount: $ad->currentPrice->amount,
                    currency: $ad->currentPrice->currency
                )
            );

            $jobs[] = new CheckAdvertPriceJob($priceData);
        }

        return $jobs;
    }
}
