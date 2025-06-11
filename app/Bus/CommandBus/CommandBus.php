<?php declare(strict_types=1);

namespace App\Bus\CommandBus;

use App\Interface\CommandBus\CommandBusInterface;
use Illuminate\Bus\Dispatcher;

/**
 * Class CommandBus
 *
 * @package App\Bus\CommandBus
 */
readonly class CommandBus implements CommandBusInterface
{
    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    /**
     * @param Command $command
     * @return mixed
     */
    public function dispatch(Command $command): mixed
    {
        return $this->dispatcher->dispatch($command);
    }

    /**
     * @param array $map
     * @return void
     */
    public function register(array $map): void
    {
        $this->dispatcher->map($map);
    }
}
