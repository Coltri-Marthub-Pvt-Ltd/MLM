<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'order',
        'image'
    ];
    
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}