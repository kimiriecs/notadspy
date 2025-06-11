<?php

namespace App\Modules\AdSpy\Http\Resource;

use App\Modules\AdSpy\Entities\Advert;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertResource extends JsonResource
{
    /**
     * @var string
     */
    public $resource = Advert::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'url' => $this->resource->url,
            'imageUrl' => $this->resource->image_url,
            'price' => PriceResource::make($this->resource->currentPrice),
        ];
    }
}
