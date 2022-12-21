<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->truncate();

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'name' => "Seed {$i}",
                'active' => rand(0, 1),
                'position' => ($i + 1),
                'type' => rand(1, 5),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ];
        }

        DB::table('banners')->insertOrIgnore($data);
    }
}
