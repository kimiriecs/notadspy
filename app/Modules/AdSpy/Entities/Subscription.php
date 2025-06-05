<?php

namespace App\Modules\AdSpy\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscription
 *
 * @package App\Modules\AdSpy\Entities
 * @property-read Advert $advert
 */
class Subscription extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'advert_id',
        'notification_email',
        'notification_email_verified_at',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }
}
