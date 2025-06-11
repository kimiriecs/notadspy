<?php declare(strict_types=1);

namespace App\Interface\QueryBus;

use App\Bus\QueryBus\Query;

/**
 * Interface QueryBusInterface
 *
 * @package App\Interface\QueryBus
 */
interface QueryBusInterface
{
    public function dispatch(Query $query): mixed;

    public function register(array $map): void;
}
