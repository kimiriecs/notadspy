<?php

namespace App\Modules\AdSpy\Http\Controller;

use App\Exception\InvalidNumberFormatException;
use App\Http\Controllers\Controller;
use App\Modules\AdSpy\Http\Request\StoreAdvertRequest;
use App\Modules\AdSpy\Http\Resource\SubscriptionResource;
use App\Modules\AdSpy\UseCase\DeleteSubscription;
use App\Modules\AdSpy\UseCase\FetchAllUserSubscriptions;
use App\Modules\AdSpy\UseCase\RegisterSubscription;
use App\Modules\AdSpy\UseCase\ToggleSubscriptionStatus;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Url;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class SubscriptionController extends Controller
{
    /**
     * @param FetchAllUserSubscriptions $action
     * @return Response
     * @throws InvalidNumberFormatException
     */
    public function index(FetchAllUserSubscriptions $action): Response
    {
        /** @var LengthAwarePaginator $ads */
        $ads = $action->fetch(NotNegativeInteger::fromNumber(Auth::id()));

        return Inertia::render(
            component: 'spy/AdvertSubscription/AdvertSubscriptions',
            props: ['ads' => SubscriptionResource::collection($ads->onEachSide(0))]
        );
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render(
            component: 'spy/AdvertSubscription/CreateAdvertSubscription'
        );
    }

    /**
     * @param StoreAdvertRequest $request
     * @param RegisterSubscription $processSubscription
     * @return RedirectResponse
     */
    public function store(
        StoreAdvertRequest $request,
        RegisterSubscription $processSubscription
    ): RedirectResponse {
        $data = $request->validated();
        try {
            $url = Url::make($data['url']);
            $processSubscription->execute($url);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        return redirect()->intended(route('subscriptions', absolute: false));
    }

    /**
     * @param int $id
     * @param ToggleSubscriptionStatus $action
     * @return RedirectResponse
     * @throws InvalidNumberFormatException
     */
    public function toggleStatus(int $id, ToggleSubscriptionStatus $action): RedirectResponse
    {
        $action->execute(NotNegativeInteger::fromNumber($id));

        return redirect()->intended(route('subscriptions', absolute: false));
    }

    /**
     * @param int $id
     * @param DeleteSubscription $action
     * @return RedirectResponse
     * @throws InvalidNumberFormatException
     */
    public function destroy(int $id, DeleteSubscription $action): RedirectResponse
    {
        $action->execute(NotNegativeInteger::fromNumber($id));

        return redirect()->intended(route('subscriptions', absolute: false));
    }
}
