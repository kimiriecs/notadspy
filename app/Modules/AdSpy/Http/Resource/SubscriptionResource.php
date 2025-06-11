<?php

namespace App\Modules\AdSpy\Http\Resource;

use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Enum\TimeZone;
use DateInvalidTimeZoneException;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * @var string
     */
    public $resource = Subscription::class;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     * @throws DateInvalidTimeZoneException
     */
    public function toArray(Request $request): array
    {
        $timezone = new DateTimeZone(TimeZone::KYIV->value);
        $advert = $this->resource->advert;
        return [
            'id' => $this->resource->id,
            'userId' => $this->resource->user_id,
            'advertUrl' => $advert->url,
            'advertTitle' => $advert->title,
            'advertImageUrl' => $advert->image_url,
            'advertCurrentPrice' => PriceResource::make($advert->currentPrice),
            'status' => $this->resource->status,
            'startedAt' => $this->resource->created_at->setTimezone($timezone)->format('Y-m-d'),
            'notificationEmail' => $this->resource->notification_email,
        ];
    }
}
