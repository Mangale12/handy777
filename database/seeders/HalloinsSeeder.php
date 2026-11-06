<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Halloin;

class HalloinsSeeder extends Seeder
{
    public function run()
    {
        Halloin::factory()->count(30)->create();
    }
}
