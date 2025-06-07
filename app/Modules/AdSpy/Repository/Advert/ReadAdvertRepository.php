<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Advert;

use App\Exception\InvalidNumberFormatException;
use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Repository\BaseReadRepository;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Url;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ReadAdvertRepository
 *
 * @package App\Modules\AdSpy\Repository\Advert
 */
class ReadAdvertRepository extends BaseReadRepository implements ReadAdvertRepositoryInterface
{
    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        return Advert::query();
    }

    /**
     * @param Url $advertUrl
     * @return Advert|null
     */
    public function findByUrl(Url $advertUrl): ?Advert
    {
        return $this->getBuilder()->firstWhere('url', $advertUrl->value());
    }

    /**
     * @return NotNegativeInteger
     * @throws InvalidNumberFormatException
     */
    public function fetchLastId(): NotNegativeInteger
    {
        $latestId = $this->getBuilder()
            ->orderByDesc('id')
            ->value('id');

        return $latestId ? NotNegativeInteger::fromNumber($latestId) : NotNegativeInteger::fromNumber(0);
    }

    /**
     * @param NotNegativeInteger[] $advertsIds
     * @return Collection<Advert>
     */
    public function fetchPricesByAdvertsIds(array $advertsIds): Collection
    {
        $ids = array_map(fn(NotNegativeInteger $id) => $id->asInt(), $advertsIds);

        return $this->getBuilder()
            ->with('currentPrice')
            ->whereIn('id', $ids)
            ->get();
    }
}
