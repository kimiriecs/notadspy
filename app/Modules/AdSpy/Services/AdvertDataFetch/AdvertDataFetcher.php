<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Services\AdvertDataFetch;

use App\Modules\AdSpy\Dto\AdvertData;
use App\Modules\AdSpy\Enum\Locale;
use App\Modules\AdSpy\Exception\AdvertClientException;
use App\Modules\AdSpy\Exception\AdvertParsingException;
use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use App\Modules\AdSpy\ValueObject\Url;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class AdvertDataFetcher
 *
 * @package App\Modules\AdSpy\Services\AdvertDataFetch
 */
readonly class AdvertDataFetcher implements AdvertDataFetcherInterface
{
    /**
     * @param AdvertClientInterface $advertClient
     * @param AdvertPageParser $pageParser
     * @param AdvertLocaleMatcher $localeMatcher
     */
    public function __construct(
        private AdvertClientInterface $advertClient,
        private AdvertPageParser $pageParser,
        private AdvertLocaleMatcher $localeMatcher
    ) {
    }

    /**
     * @param Url $url
     * @return AdvertData
     * @throws AdvertClientException
     * @throws AdvertParsingException
     */
    public function fetch(Url $url): AdvertData
    {
        $response = $this->advertClient->get($url);
        if ($response->status() !== Response::HTTP_OK) {
            throw new AdvertClientException("Unable to fetch content from the page with provided url: $url");
        }

        $data = $response->content();
        //TODO: use after research target site locale logic issue
        //$locale = $this->localeMatcher->getLocale($url);
        //TODO: remove after research target site locale logic issue
        $locale = Locale::UA;

        try {
            return $this->pageParser->parse($url, $data, $locale);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
            throw new AdvertParsingException("Unable to parse content from the page with provided url: $url");
        }
    }
}
