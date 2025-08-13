<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'product_id',
        'coins',
        'status',
        'order_by'
    ];
    // app/Models/Deal.php
protected $dates = [
    'start_date',
    'end_date',
    'created_at',
    'updated_at'
];

// OR in Laravel 8+
protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
];



    public function product()
    {
        return $this->belongsTo(CoinsProduct::class);
    }
        public function accepted()
    {
        return $this->belongsTo(AcceptDeal::class,'id','deal_id');
    }


    // Scope for active deals
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }
}
