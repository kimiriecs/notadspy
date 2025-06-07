<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Dto\PriceData;
use App\Modules\AdSpy\Enum\AdvertSelector;
use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Interface\AdvertPageParserInterface;
use App\ValueObject\ImageUrl;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;
use Dom\HTMLDocument;

/**
 * Class AdvertPageParser
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
readonly class AdvertPageParser implements AdvertPageParserInterface
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
        $dom = $this->getDom($data);
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

    /**
     * @param string $data
     * @return Price
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     */
    public function parsePrice(string $data): Price
    {
        $dom = $this->getDom($data);
        $priceText = $dom->querySelector(AdvertSelector::PRICE->value)->textContent;

        return $this->priceParser->parse($priceText);
    }

    /**
     * @param string $data
     * @return HTMLDocument
     */
    private function getDom(string $data): HTMLDocument
    {
        return HTMLDocument::createFromString($data);
    }
}
