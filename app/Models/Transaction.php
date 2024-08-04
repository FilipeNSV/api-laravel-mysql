<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property float $price
 * @property int $quantity
 * @property string $type
 * @property int $user_id
 * @property MorphTo|Employee|Supplier $ownable
 * @property Collection<User>|BelongsToMany $user_id
 */
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'quantity',
        'type',
        'user_id',
        'ownable_id',
        'ownable_type',
    ];

    /**
     * @return MorphTo|Product|Service
     */
    public function ownable(): MorphTo|Product|Service
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo|User
     */
    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }
}
