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

    public static function getAllEarnedBadges($userCoins)
    {
        return static::where('coins', '<=', $userCoins)
            ->orderBy('coins', 'asc')
            ->get();
    }
        public static function getElagibleEarnedBadges($userCoins)
    {
        return static::where('coins', '<=', $userCoins)
            ->orderBy('coins', 'asc')
            ->first();
    }

    /**
     * Get the next badge a user can work toward
     *
     * @param int $userCoins
     * @return Badge|null
     */
    public static function getNextBadge($userCoins)
    {
        return static::where('coins', '>', $userCoins)
            ->orderBy('coins', 'asc')
            ->first();
    }



}
