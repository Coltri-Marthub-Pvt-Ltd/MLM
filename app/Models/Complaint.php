<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supplied_material',
        'date',
        'city',
        'address',
        'visit_request',
        'issues'
    ];

    protected $casts = [
        'date' => 'date',
        'visit_request' => 'boolean'
    ];

    public function photos()
    {
        return $this->hasMany(ComplaintPhoto::class);
    }
}