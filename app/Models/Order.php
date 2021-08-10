<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'branch_id',
        'user_id',
        'status',
        'description',        
        'bruto',        
        'diskon',        
        'hdkp',        
        'tax',        
        'netto',        
        'active',        
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'branch_id');
    }
}
