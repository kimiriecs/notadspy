<?php

namespace App\Modules\AdSpy\Http\Request\Rule;

use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\ValueObject\Url;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class CheckUrlDomain implements ValidationRule
{
    private const array ALLOWED_DOMAINS = [
        'https://www.olx.ua/d/obyavlenie/',
        'https://www.olx.ua/d/uk/obyavlenie/'
    ];

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     * @throws ContainerExceptionInterface
     * @throws InvalidUrlFormatException
     * @throws NotFoundExceptionInterface
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isAllowedDomain = false;
        foreach (self::ALLOWED_DOMAINS as $ALLOWED_DOMAIN) {
            if (str_starts_with($value, $ALLOWED_DOMAIN)) {
                $isAllowedDomain = true;
                break;
            }
        }

        if (!$isAllowedDomain) {
            $fail('Provided :attribute is allowed');
        }

        if (!$this->checkIsBroken($value)) {
            $fail("Provided :attribute is broken or you don't have permissions to fetch from this url. Pleas check url");
        }
    }

    /**
     * @param string $url
     * @return bool
     * @throws InvalidUrlFormatException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function checkIsBroken(string $url): bool
    {
        $client = app(AdvertClientInterface::class);
        $response = $client->get(Url::make($url));

        return $response->getStatusCode() === Response::HTTP_OK;
    }
}
