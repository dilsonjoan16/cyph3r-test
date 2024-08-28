<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyRatio extends Model
{
    use HasFactory;

    protected $table = 'currency_ratio';

    protected $fillable = [
        'currency_id',
        'ratio',
    ];

    /**
     * Define the relationship between the CurrencyRatio model and the Currency model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
