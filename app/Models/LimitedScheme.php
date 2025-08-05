<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LimitedScheme extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'coins', 
        'order',
        'image'
    ];
    
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}