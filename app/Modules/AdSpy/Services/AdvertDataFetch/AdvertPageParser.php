<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Enum\AdvertSelector;
use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Exception\InvalidCurrencyFormatException;
use App\Modules\AdSpy\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Exception\InvalidTitleFormatException;
use App\Modules\AdSpy\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\ValueObject\ImageUrl;
use App\Modules\AdSpy\ValueObject\Title;
use App\Modules\AdSpy\ValueObject\Url;
use Dom\HTMLDocument;

/**
 * Class AdvertPageParser
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
readonly class AdvertPageParser
{
    public function __construct(
        private AdvertDateParser $dateParser,
        private AdvertPriceParser $priceParser
    ) {
    }

    /**
     * @param Url $url
     * @param string $data
     * @param Locale $locale
     * @return AdvertData
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     */
    public function parse(Url $url, string $data, Locale $locale): AdvertData
    {
        $dom = HTMLDocument::createFromString($data);
        $titleText = $dom->querySelector(AdvertSelector::TITLE->value)->textContent;
        $title = Title::make($titleText);

        $imageSrc = $dom->querySelector(AdvertSelector::IMAGE->value)->getAttribute('src');
        $imageUrl = ImageUrl::make($imageSrc);

        $postedAtText = $dom->querySelector(AdvertSelector::DATE->value)->textContent;
        $postedAt = $this->dateParser->parse($postedAtText, $locale);

        $priceText = $dom->querySelector(AdvertSelector::PRICE->value)->textContent;
        $price = $this->priceParser->parse($priceText);

        return new AdvertData(
            title: $title,
            url: $url,
            imageUrl: $imageUrl,
            postedAt: $postedAt,
            price: new PriceData($price)
        );
    }
}
