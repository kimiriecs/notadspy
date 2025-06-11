<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Advert;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Advert\DeleteAdvert;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;

/**
 * Class DeleteAdvertHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Advert
 */
readonly class DeleteAdvertHandler implements CommandHandlerInterface
{
    /**
     * @param WriteAdvertRepositoryInterface $repository
     */
    public function __construct(
        private WriteAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param DeleteAdvert $command
     * @return bool
     */
    public function handle(Command $command): bool
    {
        return $this->repository->delete($command->getAdvertId());
    }
}
