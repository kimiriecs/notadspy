<?php

namespace App\Modules\AdSpy\Http\Resource;

use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Enum\CurrencySymbol;
use App\Modules\AdSpy\Enum\TimeZone;
use DateInvalidTimeZoneException;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * @var string
     */
    public $resource = Price::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @throws DateInvalidTimeZoneException
     */
    public function toArray(Request $request): array
    {
        $timezone = new DateTimeZone(TimeZone::KYIV->value);
        return [
            'id' => $this->resource->id,
            'amount' => $this->resource->amount,
            'currency' => $this->resource->currency,
            'currencySymbol' => CurrencySymbol::tryFromName($this->resource->currency)?->value ?? '',
            'advertId' => $this->resource->advert_id,
            'createdAt' => $this->resource->created_at->setTimezone($timezone)->format('Y-m-d'),
        ];
    }
}
