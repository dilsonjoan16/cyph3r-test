<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'United States Dollar',
                'iso3' => 'USD',
                'symbol' => '$',
            ],
            [
                'name' => 'Venezuelan Bolívar',
                'iso3' => 'VES',
                'symbol' => 'Bs',
            ],
            [
                'name' => 'Euro',
                'iso3' => 'EUR',
                'symbol' => '€',
            ],
            [
                'name' => 'Colombian Peso',
                'iso3' => 'COP',
                'symbol' => 'COL$',
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
