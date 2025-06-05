<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Repository\Advert;

use App\Modules\AdSpy\Entities\Advert;
use App\Modules\AdSpy\Interface\Repository\Advert\ReadAdvertRepositoryInterface;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Modules\AdSpy\ValueObject\Url;
use App\Repository\BaseReadRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
}
