<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property Collection<Transaction>|HasMany $transactions
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    /**
     * @return HasMany<Transaction>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
