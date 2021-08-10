<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\OrderDetail::factory(20)->create();
    }
}
