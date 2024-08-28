<?php

namespace Database\Seeders;

use App\Enums\Currency;
use App\Models\CurrencyRatio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencyRatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ratios = [
            [
                'currency_id' => Currency::USD,
                'ratio' => 1
            ],
            [
                'currency_id' => Currency::EUR,
                'ratio' => 1.3
            ],
            [
                'currency_id' => Currency::VES,
                'ratio' => 37
            ],
            [
                'currency_id' => Currency::COP,
                'ratio' => 4000
            ],
        ];

        foreach ($ratios as $ratio) {
            CurrencyRatio::create($ratio);
        }
    }
}
