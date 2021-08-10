<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::create([            
            'code'=>'01',
            'name'=>'Cleansing & Freshenner',
            'photo'=>'',
            'slug'=>'cleansing-Freshenner',            
        ]);
        \App\Models\Category::create([            
            'code'=>'02',
            'name'=>'Face Make Up',
            'photo'=>'',
            'slug'=>'face-make-up',            
        ]);
         \App\Models\Category::create([            
            'code'=>'03',
            'name'=>'Eye Make Up',
            'photo'=>'',
            'slug'=>'eye-make-up',            
        ]);
         \App\Models\Category::create([            
            'code'=>'04',
            'name'=>'Skin Care',
            'photo'=>'',
            'slug'=>'skin-care',            
        ]);
         \App\Models\Category::create([            
            'code'=>'05',
            'name'=>'Lips Make Up',
            'photo'=>'',
            'slug'=>'lips-make-up',            
        ]);
         \App\Models\Category::create([            
            'code'=>'06',
            'name'=>'Body Care',
            'photo'=>'',
            'slug'=>'body-care',            
        ]);
        \App\Models\Category::create([            
            'code'=>'07',
            'name'=>'Body Parfume',
            'photo'=>'',
            'slug'=>'body-parfume',            
        ]);
         \App\Models\Category::create([            
            'code'=>'09',
            'name'=>'Accesssories & Others',
            'photo'=>'',
            'slug'=>'accesssories-others',            
        ]);
    }
}
