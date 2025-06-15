<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Advert;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Advert\RestoreAdvert;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;

/**
 * Class RestoreAdvertHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Advert
 */
readonly class RestoreAdvertHandler implements CommandHandlerInterface
{
    /**
     * @param WriteAdvertRepositoryInterface $repository
     */
    public function __construct(
        private WriteAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param RestoreAdvert $command
     * @return bool
     */
    public function handle(Command $command): bool
    {
        return $this->repository->restore($command->getAdvertId());
    }
}
