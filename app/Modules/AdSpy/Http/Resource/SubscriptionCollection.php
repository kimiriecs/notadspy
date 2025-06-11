<?php

namespace App\Modules\AdSpy\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriptionCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = SubscriptionResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, SubscriptionResource>
     */
    public function toArray(Request $request): array
    {
        return [$this->collection];
        // return [
        //     'data' => $this->collection,
        //     'links' => [
        //         'items' => $this->items(),
        //         'currentPage' => $this->currentPage(),
        //         'perPage' => $this->perPage(),
        //         'nextPageUrl' => $this->nextPageUrl(),
        //         'previousPageUrl' => $this->previousPageUrl(),
        //         'lastPage' => $this->lastPage(),
        //         'onFirstPage' => $this->onFirstPage(),
        //         'onLastPage' => $this->onLastPage(),
        //         'count' => $this->count()
        //     ]
        // ];
    }
}
