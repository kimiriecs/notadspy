<?php declare(strict_types=1);

namespace App\Bus\QueryBus;

use App\Interface\QueryBus\QueryBusInterface;
use Illuminate\Bus\Dispatcher;

/**
 * Class QueryBus
 *
 * @package App\Bus\QueryBus
 */
readonly class QueryBus implements QueryBusInterface
{
    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    /**
     * @param Query $query
     * @return mixed
     */
    public function dispatch(Query $query): mixed
    {
        return $this->dispatcher->dispatch($query);
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
