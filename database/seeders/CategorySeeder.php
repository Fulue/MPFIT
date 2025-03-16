<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            [
                'name' => 'легкий',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'хрупкий',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'тяжелый',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
