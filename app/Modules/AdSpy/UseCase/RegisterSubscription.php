<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Interface\CommandBus\CommandBusInterface;
use App\Interface\QueryBus\QueryBusInterface;
use App\Models\User;
use App\Modules\AdSpy\CommandBus\Command\Advert\StoreAdvert;
use App\Modules\AdSpy\CommandBus\Command\Price\StorePrice;
use App\Modules\AdSpy\CommandBus\Command\Subscription\StoreSubscription;
use App\Modules\AdSpy\Dto\SubscriptionData;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Entities\Subscription;
use App\Modules\AdSpy\Enum\SubscriptionStatus;
use App\Modules\AdSpy\Exception\InvalidEmailFormatException;
use App\Modules\AdSpy\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Interface\AdvertDataFetcherInterface;
use App\Modules\AdSpy\QueryBus\Query\Advert\FindAdvertByUrl;
use App\Modules\AdSpy\QueryBus\Query\Subscription\FindUserSubscriptionByAdvertId;
use App\Modules\AdSpy\ValueObject\Email;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Modules\AdSpy\ValueObject\Url;
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
     */
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @throws InvalidNumberFormatException
     * @throws InvalidEmailFormatException
     */
    public function execute(Url $url): true
    {
        /** @var Advert|null $existingAdvert */
        $advert = $this->queryBus->dispatch(new FindAdvertByUrl($url));
        if (!$advert) {
            $fetcher = app(AdvertDataFetcherInterface::class);
            $advertData = $fetcher->fetch($url);
            /** @var Advert $advert */
            $advert = $this->commandBus->dispatch(new StoreAdvert($advertData));
            $this->commandBus->dispatch(
                new StorePrice(
                    NotNegativeInteger::fromNumber($advert->id),
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
}
