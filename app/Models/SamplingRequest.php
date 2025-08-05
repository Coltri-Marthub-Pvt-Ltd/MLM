<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamplingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'variant',
        'phone',
        'contact_details',
        'visit_request',
        'other_details'
    ];

    protected $casts = [
        'visit_request' => 'boolean'
    ];
}