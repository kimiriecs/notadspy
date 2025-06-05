<?php declare(strict_types=1);

namespace App\Modules\AdSpy\QueryBus\Query\Subscription;

use App\Bus\QueryBus\Query;
use App\Modules\AdSpy\ValueObject\Url;

/**
 * Class FindSubscriptionByUrl
 *
 * @package App\Modules\AdSpy\QueryBus\Query\Subscription
 */
class FindSubscriptionByUrl extends Query
{
    /**
     * @param Url $subscriptionUrl
     */
    public function __construct(private readonly Url $subscriptionUrl)
    {
    }

    /**
     * @return Url
     */
    public function getSubscriptionUrl(): Url
    {
        return $this->subscriptionUrl;
    }
}
