<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Interface\Repository\Advert;

use App\Interface\Repository\ReadRepositoryInterface;
use App\Modules\AdSpy\Entities\Advert;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Url;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ReadAdvertRepositoryInterface
 *
 * @package App\Modules\AdSpy\Interface\Repository\Advert
 */
interface ReadAdvertRepositoryInterface extends ReadRepositoryInterface
{
    /**
     * @param Url $advertUrl
     * @return Advert|null
     */
    public function findByUrl(Url $advertUrl): ?Advert;

    /**
     * @return NotNegativeInteger
     */
    public function fetchLastId(): NotNegativeInteger;

    /**
     * @param array<NotNegativeInteger> $advertsIds
     * @return Collection<Advert>
     */
    public function fetchPricesByAdvertsIds(array $advertsIds): Collection;
}
