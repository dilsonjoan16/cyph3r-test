<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Enums\Currency as EnumsCurrency;

class CurrencyController extends Controller
{

    /**
     * Updates the current currency for the authenticated user.
     *
     * @param string $currency The ISO 4217 code of the currency to be set as the user's current currency.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCurrentCurrency(string $currency): RedirectResponse
    {
        User::find(auth()->user()->id)->update(['current_currency_iso3' => $currency]);

        session()->put('currency', EnumsCurrency::currencyByIso3($currency));

        return redirect()->back();
    }
}
