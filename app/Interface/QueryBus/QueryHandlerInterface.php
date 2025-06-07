<?php declare(strict_types=1);

namespace App\Interface\QueryBus;

use App\Bus\QueryBus\Query;

/**
 * Interface QueryHandlerInterface
 *
 * @package App\Interface\QueryBus
 */
interface QueryHandlerInterface
{
    public function handle(Query $query): mixed;
}
