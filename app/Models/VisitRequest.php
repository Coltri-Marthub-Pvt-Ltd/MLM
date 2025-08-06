<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    use HasFactory;

    protected $table = 'visit_requests';

    protected $fillable = [
        'user_id',
        'name',
        'variant',
        'phone',
        'city',
        'address',
        'order_issue',
        'sampling_tokens'
    ];
}