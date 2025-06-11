<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Client;

use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\ValueObject\Url;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class AdvertClient
 *
 * @package App\Modules\AdSpy\Client
 */
class AdvertClient implements AdvertClientInterface
{
    public function __construct(
        private Client $client
    ) {
    }

    /**
     * @param Url $url
     * @return Response
     */
    public function get(Url $url): Response
    {
        $content = [];
        $status = Response::HTTP_BAD_REQUEST;
        try {
            $response = $this->client
                ->request(
                    method: Request::METHOD_GET,
                    uri: $url->value(),
                    options: $this->options()
                );

            $content = $response->getBody();
            $status = Response::HTTP_OK;
        } catch (GuzzleException $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        return new Response(
            content: $content,
            status: $status
        );
    }

    /**
     * @return array
     */
    private function options(): array
    {
        $headers = [];
        return [
            'headers' => $headers
        ];
    }
}
