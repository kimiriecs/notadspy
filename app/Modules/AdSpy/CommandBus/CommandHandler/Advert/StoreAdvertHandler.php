<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Advert;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Advert\StoreAdvert;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;

/**
 * Class StoreAdvertHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Advert
 */
readonly class StoreAdvertHandler implements CommandHandlerInterface
{
    /**
     * @param WriteAdvertRepositoryInterface $repository
     */
    public function __construct(
        private WriteAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param StoreAdvert $command
     * @return Advert
     */
    public function handle(Command $command): Advert
    {
        return $this->repository->store($command->getData());
    }
}
