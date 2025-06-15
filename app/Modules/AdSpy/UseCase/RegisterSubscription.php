<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Exception\InvalidEmailFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Interface\CommandBus\CommandBusInterface;
use App\Interface\QueryBus\QueryBusInterface;
use App\Modules\AdSpy\CommandBus\Command\Advert\RestoreAdvert;
use App\Modules\AdSpy\CommandBus\Command\Advert\StoreAdvert;
use App\Modules\AdSpy\CommandBus\Command\Advert\UpdateAdvert;
use App\Modules\AdSpy\CommandBus\Command\Price\StorePrice;
use App\Modules\AdSpy\CommandBus\Command\Subscription\StoreSubscription;
use App\Modules\AdSpy\Dto\SubscriptionData;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Enum\SubscriptionStatus;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertByUrlWithTrashed;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindUserSubscriptionByAdvertId;
use App\Modules\User\Entities\User;
use App\ValueObject\Email;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Url;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;

/**
 * Class RegisterSubscription
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class RegisterSubscription
{
    /**
     * @param QueryBusInterface $queryBus
     * @param CommandBusInterface $commandBus
     * @param AdvertDataFetcherInterface $fetcher
     */
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
        private AdvertDataFetcherInterface $fetcher
    ) {
    }

    /**
     * @throws InvalidNumberFormatException
     * @throws InvalidEmailFormatException
     */
    public function execute(Url $url): true
    {
        /** @var Advert|null $existingAdvert */
        $advert = $this->queryBus->dispatch(new FindAdvertByUrlWithTrashed($url));

        if (!$advert) {
            $advertData = $this->fetcher->fetch($url);
            /** @var Advert $advert */
            $advert = $this->commandBus->dispatch(new StoreAdvert($advertData));
            $this->commandBus->dispatch(
                new StorePrice(
                    NotNegativeInteger::fromNumber($advert->id),
                    $advertData->getPrice()
                )
            );
        }

        if ($advert->trashed()) {
            $advertId = NotNegativeInteger::fromNumber($advert->id);
            $this->commandBus->dispatch(new RestoreAdvert($advertId));
            $advertData = $this->fetcher->fetch($url);
            /** @var Advert $advert */
            $advert = $this->commandBus->dispatch(new UpdateAdvert($advertId, $advertData));
            $this->commandBus->dispatch(
                new StorePrice(
                    $advertId,
                    $advertData->getPrice()
                )
            );
        }

        /** @var User $user */
        $user = Auth::user();
        /** @var Subscription|null $subscription */
        $subscription = $this->queryBus->dispatch(
            new FindUserSubscriptionByAdvertId(
                NotNegativeInteger::fromNumber($user->id),
                NotNegativeInteger::fromNumber($advert->id)
            )
        );

        if (!$subscription) {
            $subscriptionData = new SubscriptionData(
                userId: NotNegativeInteger::fromNumber($user->id),
                advertId: NotNegativeInteger::fromNumber($advert->id),
                notificationEmail: Email::make($user->email),
                notificationEmailVerifiedAt: DateTimeImmutable::createFromMutable($user->email_verified_at),
                status: SubscriptionStatus::ACTIVE
            );

            $this->commandBus->dispatch(new StoreSubscription($subscriptionData));
        }

        return true;
    }

    private function createNew()
    {

    }
}
