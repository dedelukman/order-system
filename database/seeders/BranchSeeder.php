<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Branch::create([
            'code'=>'ADL',
            'name'=>'PT. Araya Distriversa Lestari',
            'address'=>'Jl. Limau Raya Harapan Baru Bekasi',
            'category'=>'PUSAT',
            'price'=>'HJ',
            'discount'=>'0',
            'active'=>'1'
        ]);
        \App\Models\Branch::create([
            'code'=>'AJB',
            'name'=>'PT. Araya Cabang Jabotabek',
            'address'=>'Jl. Limau Raya Harapan Baru Bekasi',
            'category'=>'CABANG',
            'price'=>'HJ',
            'discount'=>'0',
            'active'=>'1'
        ]);
        
         \App\Models\Branch::create([
            'code'=>'ASM',
            'name'=>'PT. Araya Cabang Semarang',
            'address'=>'Semarang',
            'category'=>'CABANG',
            'price'=>'HJ',
            'discount'=>'0',
            'active'=>'1'
        ]);
         \App\Models\Branch::create([
            'code'=>'AML',
            'name'=>'PT. Araya Cabang Malang',
            'address'=>'Malang',
            'category'=>'CABANG',
            'price'=>'HJ',
            'discount'=>'0',
            'active'=>'1'
        ]);
        
    }
}
