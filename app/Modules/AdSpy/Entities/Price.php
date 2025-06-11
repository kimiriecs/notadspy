<?php

namespace App\Modules\AdSpy\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Price
 *
 * @package App\Modules\AdSpy\Entities
 * @mixin IdeHelperPrice
 */
class Price extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'advert_id',
        'amount',
        'currency',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }
}
