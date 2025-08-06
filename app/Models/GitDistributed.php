<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GitDistributed extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
       'name',
        'date',
        'city',
        'location_id',
        'image'
    ];

    protected $casts = [
    'date' => 'date',
    // other casts...
];

        public function location()
    {
        return $this->belongsTo(Location::class);
    }
}