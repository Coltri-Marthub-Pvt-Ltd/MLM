<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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
        return $this->belongsTo(product::class,'product_id','id');
    }
        public function contractor()
    {
        return $this->belongsTo(Contractor::class,'user_id','id');
    }
}
