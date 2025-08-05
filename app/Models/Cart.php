<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart'; 
    protected $fillable = ['user_id','product_id','qty','price','points'];

        public function product()
    {
        return $this->belongsTo(product::class,'product_id','id');
    }
}

