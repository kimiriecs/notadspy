<?php declare(strict_types=1);

namespace App\Interface\CommandBus;

use App\Bus\CommandBus\Command;
use App\Modules\AdSpy\Entities\Advert;

/**
 * Interface CommandHandlerInterface
 *
 * @package App\Interface\CommandBus
 */
interface CommandHandlerInterface
{
    public function handle(Command $command): mixed;
}
