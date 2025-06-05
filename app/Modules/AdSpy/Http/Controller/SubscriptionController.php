<?php

namespace App\Modules\AdSpy\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\AdSpy\Http\Request\StoreAdvertRequest;
use App\Modules\AdSpy\UseCase\RegisterSubscription;
use App\Modules\AdSpy\ValueObject\Url;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $ads = [
            [
                'url' => 'https://some-url.test/ad-1',
                'notificationEmail' => 'u1@test.com',
                'state' => 'active',
                'price' => [
                    'value' => 100,
                    'currency' => 'UAH',
                    'lastCheck' => '2025-03-15'
                ]
            ],
            [
                'url' => 'https://some-url.test/ad-1',
                'notificationEmail' => 'u1@test.com',
                'state' => 'active',
                'price' => [
                    'value' => 100,
                    'currency' => 'UAH',
                    'lastCheck' => '2025-03-15'
                ]
            ]
        ];

        return Inertia::render(
            component: 'AdvertSubscriptions',
            props: ['ads' => $ads]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $channels = [
            'mail' => [
                $user->email,
                'qw@sd.cv',
                'qasas@sd.cv',
            ]
        ];

        return Inertia::render(
            component: 'spy/AdvertSubscription/CreateAdvertSubscription',
            props: ['channels' => $channels]
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
