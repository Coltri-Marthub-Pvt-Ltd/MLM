<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GitCard extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'coins', 
        'orderBY',
        'image'
    ];
    
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}