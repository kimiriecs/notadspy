<?php

namespace App\Modules\AdSpy\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PriceCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = PriceResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, PriceResource>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
