<?php declare(strict_types=1);

namespace App\Modules\AdSpy\CommandBus\CommandHandler\Advert;

use App\Bus\CommandBus\Command;
use App\Interface\CommandBus\CommandHandlerInterface;
use App\Modules\AdSpy\CommandBus\Command\Advert\UpdateAdvert;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\WriteAdvertRepositoryInterface;

/**
 * Class UpdateAdvertHandler
 *
 * @package App\Modules\AdSpy\CommandBus\CommandHandler\Advert
 */
class UpdateAdvertHandler implements CommandHandlerInterface
{
    /**
     * @param WriteAdvertRepositoryInterface $repository
     */
    public function __construct(
        private WriteAdvertRepositoryInterface $repository
    ) {
    }

    /**
     * @param UpdateAdvert $command
     * @return Advert
     */
    public function handle(Command $command): Advert
    {
        return new Advert;
    }
}
