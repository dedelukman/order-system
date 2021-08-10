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
            'code'=>'ALP',
            'name'=>'PT. Araya Cabang Lampung',
            'address'=>'Lampung',
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
         \App\Models\Branch::create([
            'code'=>'IJL',
            'name'=>'PT. Indah Jaya Lestari',
            'address'=>'Medan',
            'category'=>'DISTRIBUTOR',
            'price'=>'HET2',
            'discount'=>'0',
            'active'=>'1'
        ]);
         \App\Models\Branch::create([
            'code'=>'HPA',
            'name'=>'CV. HANNA PUTRI AYU',
            'address'=>'Kupang',
            'category'=>'DISTRIBUTOR',
            'price'=>'HET2',
            'discount'=>'0',
            'active'=>'1'
        ]);
        \App\Models\Branch::create([
            'code'=>'ADF',
            'name'=>'PT. ADITYA FARMATAMA',
            'address'=>'Kupang',
            'category'=>'DISTRIBUTOR',
            'price'=>'HET2',
            'discount'=>'30',
            'active'=>'1'
        ]);
         \App\Models\Branch::create([
            'code'=>'BKS',
            'name'=>'AGEN BEKASI',
            'address'=>'Bekasi',
            'category'=>'AGEN',
            'price'=>'HET2',
            'discount'=>'37',
            'active'=>'1'
        ]);
         \App\Models\Branch::create([
            'code'=>'TGL',
            'name'=>'AGEN TEGAL',
            'address'=>'Tegal',
            'category'=>'AGEN',
            'price'=>'HET2',
            'discount'=>'37',
            'active'=>'1'
        ]);
        \App\Models\Branch::create([
            'code'=>'TGR',
            'name'=>'AGEN TGR',
            'address'=>'Tanggerang',
            'category'=>'AGEN',
            'price'=>'HET2',
            'discount'=>'35',
            'active'=>'1'
        ]);
        \App\Models\Branch::create([
            'code'=>'PWO',
            'name'=>'AGEN PURWOKERTO',
            'address'=>'Purwokerto',
            'category'=>'AGEN',
            'price'=>'HET2',
            'discount'=>'35',
            'active'=>'1'
        ]);
    }
}
