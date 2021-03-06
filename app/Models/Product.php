<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    

    protected $fillable = [
        'code',
        'name',
        'hj',
        'het2',
        'photo',        
        'stok1',        
        'stok2',        
        'photo',        
        'description',        
        'category_id',        
        'active',        
    ];
}
