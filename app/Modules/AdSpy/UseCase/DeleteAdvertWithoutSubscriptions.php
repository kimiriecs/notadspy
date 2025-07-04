<?php declare(strict_types=1);

namespace App\Modules\AdSpy\UseCase;

use App\Exception\InvalidNumberFormatException;
use App\Interface\CommandBus\CommandBusInterface;
use App\Modules\AdSpy\CommandBus\Command\Advert\DeleteAdvert;
use App\Modules\AdSpy\Entities\Advert;
use App\ValueObject\NotNegativeInteger;

/**
 * Class DeleteAdvertWithoutSubscriptions
 *
 * @package App\Modules\AdSpy\UseCase
 */
readonly class DeleteAdvertWithoutSubscriptions
{

    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @param Advert $advert
     * @return bool
     * @throws InvalidNumberFormatException
     */
    public function execute(Advert $advert): bool
    {
        $hasActiveSubscriptions = $advert->subscriptions()->get()->count() > 0;
        if ($hasActiveSubscriptions) {
            return true;
        }

        $deleteCommand = new DeleteAdvert(NotNegativeInteger::fromNumber($advert->id));

        return $this->commandBus->dispatch($deleteCommand);
    }
}
