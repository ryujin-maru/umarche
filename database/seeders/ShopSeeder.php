<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'ここにお店の名前が入ります。',
                'information' => 'ここにお店の名前が入ります。ここにお店の名前が入ります。ここにお店の名前が入ります。ここにお店の名前が入ります。',
                'filename' => '',
                'is_selling' => true,
            ],
            [
                'owner_id' => 2,
                'name' => 'ここにお店の名前が入ります。',
                'information' => 'ここにお店の名前が入ります。ここにお店の名前が入ります。ここにお店の名前が入ります。ここにお店の名前が入ります。',
                'filename' => '',
                'is_selling' => true,
            ],
        ]);
    }
}
