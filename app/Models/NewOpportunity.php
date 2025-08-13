<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewOpportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_id',
        'location_id',
        'project_name',
        'area',
        'client_name',
        'client_phone',
        'order',
        'project_brief'
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}