<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crops;

class CropsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        Crops::create([
            'name' => 'Wheat',
            'description' => 'Wheat is a cereal grain that is a staple food in many parts of the world.',
            'image' => asset('../agriloop/public/images/wheat.jpg'),
        ]);
        Crops::create([
            'name' => 'Rice',
            'description' => 'Rice is a staple food for more than half of the world\'s population.',
            'image' => asset('../agriloop/public/images/rice.jpg'),
        ]);
        Crops::create([
            'name' => 'Corn',
            'description' => 'Corn is a cereal plant that yields large grains, or kernels, set in rows on a cob.',
            'image' => asset('../agriloop/public/images/corn.jpg'),
        ]);
        Crops::create([
            'name' => 'Soybean',
            'description' => 'Soybean is a species of legume native to East Asia, widely grown for its edible bean.',
            'image' => asset('../agriloop/public/images/soybean.jpg'),
        ]);
        Crops::create([
            'name' => 'Barley',
            'description' => 'Barley is a cereal grain that is used for food, animal feed, and brewing.',
            'image' => asset('../agriloop/public/images/barley.jpg'),
        ]);
        Crops::create([
            'name' => 'Oats',
            'description' => 'Oats are a cereal grain that is commonly used for food and animal feed.',
            'image' => asset('../agriloop/public/images/oats.jpg'),
        ]);
    }
}
