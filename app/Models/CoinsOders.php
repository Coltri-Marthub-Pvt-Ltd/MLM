<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinsOders extends Model
{
     use HasFactory;
    protected $table =  'coins_orders';
    protected $fillable = [
        'order_number',
        'date',
        'mkt_person',
        'partner_id',
        'client',
        'area',
        'product_id',
        'qty',
        'rate',
        'transport',
        'supplier',
        'partner_commission'
    ];

    public function product()
    {
        return $this->belongsTo(CoinsProduct::class,'product_id','id');
    }
        public function contractor()
    {
        return $this->belongsTo(Contractor::class,'user_id','id');
    }
}
