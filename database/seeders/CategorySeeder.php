<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronics is a technology company and services provider for consumer electronic devices.',
            ],

            [
                'name' => 'Books',
                'description' => 'Books are a form of written work.',
            ],

            [
                'name' => 'Clothing',
                'description' => 'Clothing is a form of clothing.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
