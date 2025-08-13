<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'locations';
    protected $fillable = ['name'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
