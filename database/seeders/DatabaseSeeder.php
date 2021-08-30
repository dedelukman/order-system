<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BranchSeeder::class,          
        ]);
        \App\Models\User::factory(20)->create();
         \App\Models\User::create([            
            'name'=>'Dede',
            'email'=>'dede@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'ADMIN',
            'branch_id'=>'1',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        \App\Models\User::create([            
            'name'=>'Dede',
            'email'=>'dlukmanul.h@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'ADMIN',
            'branch_id'=>'2',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        $this->call([
        CategorySeeder::class,
        ProductSeeder::class,
        OrderSeeder::class,
        OrderDetailSeeder::class,
    ]);
    }
}
