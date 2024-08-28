<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'description' => 'Apple is a technology company and services provider for consumer electronic devices.',
            ],

            [
                'name' => 'Ryan Holiday',
                'description' => 'Ryan Holiday is a stoic writer and poet.',
            ],

            [
                'name' => 'Nike',
                'description' => 'Nike is a clothing brand.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
