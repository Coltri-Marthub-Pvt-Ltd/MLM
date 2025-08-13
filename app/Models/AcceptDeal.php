<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcceptDeal extends Model
{
    protected $table = "accept_deal";
    protected $fillable = ['deal_id','user_id','coins'];
}
