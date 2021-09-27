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
        \App\Models\User::create([            
            'name'=>'Agus Setijawan',
            'email'=>'wawan@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'ADMIN',
            'branch_id'=>'1',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
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
            'name'=>'Ida Farida',
            'email'=>'idf@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'ADMIN',
            'branch_id'=>'1',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        \App\Models\User::create([            
            'name'=>'Asep Firman',
            'email'=>'abo@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'ADMIN',
            'branch_id'=>'1',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
      
      
        \App\Models\User::create([            
            'name'=>'Redi',
            'email'=>'redi@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'USER',
            'branch_id'=>'3',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        \App\Models\User::create([            
            'name'=>'Deden',
            'email'=>'deden@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'USER',
            'branch_id'=>'2',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        \App\Models\User::create([            
            'name'=>'Sanudi',
            'email'=>'malang@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'USER',
            'branch_id'=>'4',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        \App\Models\User::create([            
            'name'=>'Ucu Samsudin',
            'email'=>'ucu@araya.co.id',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role'=>'USER',
            'branch_id'=>'5',
            'active'=>'1',
            'email_verified_at' => now()
        ]);
        $this->call([
        
        CategorySeeder::class,
        ProductSeeder::class,
      
    ]);
    }
}
