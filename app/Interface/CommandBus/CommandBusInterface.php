<?php declare(strict_types=1);

namespace App\Interface\CommandBus;

use App\Bus\CommandBus\Command;

/**
 * Interface CommandBusInterface
 *
 * @package App\Interface\CommandBus
 */
interface CommandBusInterface
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
