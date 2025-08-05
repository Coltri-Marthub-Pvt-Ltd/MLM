<?php

// app/Models/Badge.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = ['name', 'image', 'coins'];
    
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}