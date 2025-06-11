<?php

namespace Database\Seeders;

use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Entities\Price;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Interface\AdvertClientInterface;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use App\Modules\User\Entities\User;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Url;
use Dom\HTMLDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class AdvertSeeder extends Seeder
{
    private const string BASE_URL = 'https://www.olx.ua';
    private const string ADVERTS_URL = 'https://www.olx.ua/transport/legkovye-avtomobili/?currency=USD&search%5Bfilter_enum_car_option%5D%5B0%5D=park_assist&search%5Bfilter_enum_car_state_type%5D%5B0%5D=new';
    private const string ADVERT_CARD_SELECTOR = 'div[data-testid="l-card"] div[data-cy="ad-card-title"] > a';

    public function __construct(
        private readonly AdvertDataFetcherInterface $fetcher
    ) {
    }

    /**
     * @return void
     * @throws InvalidNumberFormatException
     * @throws InvalidUrlFormatException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        $client = app(AdvertClientInterface::class);

        $page = $client->get(Url::make(self::ADVERTS_URL));
        $dom = HTMLDocument::createFromString($page->getContent());
        $advertsUrls = $dom->querySelectorAll(self::ADVERT_CARD_SELECTOR);
        $adverts = [];
        $preservedOldPriceAdverts = [5, 10, 15, 20, 25, 30];
        $prices = [];
        foreach ($advertsUrls as $key => $advertsUrl) {
            $advertUrl = self::BASE_URL . $advertsUrl->getAttribute('href');
            try {
                $advertData = $this->fetcher->fetch(Url::make($advertUrl));
            } catch (Throwable $e) {
                continue;
            }

            //generate Advert
            $advertId = $key;
            $adverts[$advertId] = [
                'id' => $advertId,
                'url' => $advertData->getUrl()->value(),
                'title' => $advertData->getTitle()->value(),
                'image_url' => $advertData->getImageUrl()->value(),
                'posted_at' => $advertData->getPostedAt()->format('Y-m-d'),
            ];

            //generate Price
            $isOldPrice = in_array($advertId, $preservedOldPriceAdverts);
            $priceAmount = $advertData->getPrice()->getAmount()->asInt();
            $priceId = $advertId;
            $prices[] = [
                'id' => $priceId,
                'advert_id' => NotNegativeInteger::fromNumber($advertId),
                'amount' => $isOldPrice ? $priceAmount - 100 : $priceAmount,
                'currency' => $advertData->getPrice()->getCurrency()->value(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $users = [];
        foreach (range(1, 3) as $userId) {
            $users[$userId] = [
                'id' => $userId,
                'email' => "u$userId@test.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'name' => "user$userId",
            ];
        }

        //generate subscriptions
        $oldPriceSubscriptionsMap = [
            1 => [10],
            2 => [15, 20],
            3 => [25, 30, 35],
        ];
        $actualPricesAdvertsIds = array_filter(
            array_keys($adverts),
            function ($item) use ($preservedOldPriceAdverts) {
                return !in_array($item, $preservedOldPriceAdverts);
            }
        );
        $actualPricesSubscriptionsMap = [];
        shuffle($actualPricesAdvertsIds);
        $userId = 1;
        foreach ($actualPricesAdvertsIds as $id) {
            $actualPricesSubscriptionsMap[$userId][] = $id;
            $userId = $userId === 3 ? 1 : $userId +1;
        }

        $subscriptionsMap = [];
        foreach ($actualPricesSubscriptionsMap as $userId => $map) {
            $subscriptionsMap[$userId] = array_merge($oldPriceSubscriptionsMap[$userId], $map);
        }

        $subscriptions = [];
        $subscriptionId = 1;
        foreach ($subscriptionsMap as $userId => $advertIds) {
            foreach ($advertIds as $advertId) {
                $subscriptions[] = [
                    'id' => $subscriptionId,
                    'user_id' => $userId,
                    'advert_id' => $advertId,
                    'notification_email' => $users[$userId]['email'],
                    'notification_email_verified_at' => $users[$userId]['email_verified_at'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $subscriptionId++;
            }
        }


        // store all entities
        Artisan::call('migrate:fresh');
        User::query()->insert($users);
        Advert::query()->insert($adverts);
        Price::query()->insert($prices);
        Subscription::query()->insert($subscriptions);
    }
}
