<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewScheme extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'order',
        'image'
    ];
    
    protected $table = 'new_schemes';
    
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}