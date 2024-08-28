<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'status'
    ];

    protected $casts = [
        'status' => TransactionStatus::class
    ];

    /**
     * Returns the wallet that this transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Returns a BelongsToMany relationship with the Product model.
     *
     * This relationship is defined by the product_transaction pivot table.
     * The foreign key on the transactions table is transaction_id.
     * The foreign key on the products table is product_id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_transaction', 'transaction_id', 'product_id')->withTimestamps();
    }
}
