<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Illuminate\Http\RedirectResponse;

class ShoppingController extends Controller
{

    /**
     * Delete a product from a shopping transaction.
     *
     * Detach the given product from the given shopping transaction.
     *
     * @param Transaction $shopping The shopping transaction to remove the product from.
     * @param Product $product The product to remove from the shopping transaction.
     * @return \Illuminate\Http\RedirectResponse A redirect to the current page.
     */
    public function deleteProduct(Transaction $shopping, Product $product): RedirectResponse
    {
        $shopping->products()->detach($product->id);

        return redirect()->current();
    }

    /**
     * Complete a shopping transaction.
     *
     * Update the status of the shopping transaction to success and subtract the
     * transaction amount from the user's wallet balance. Then redirect to the
     * product index page.
     *
     * @param Transaction $shopping The shopping transaction to complete.
     * @return \Illuminate\Http\RedirectResponse A redirect to the product index page.
     */
    public function complete(Transaction $shopping): RedirectResponse
    {
        $shopping->status = TransactionStatus::SUCCESS->value;
        $shopping->save();

        $shopping->wallet->balance -= $shopping->amount;
        $shopping->wallet->save();

        return redirect()->route('products.index');
    }
}
