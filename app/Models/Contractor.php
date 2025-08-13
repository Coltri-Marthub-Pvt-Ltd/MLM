<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'aadhar_card',
        'aadhar_photo',
        'pan_card',
        'pan_photo',
        'date_of_birth',
        'address',
        'password',
        'status',
        'points',
        'verified_at',
        'verified_by',
        'referenced_by', // add this
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'status' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Check if contractor is eligible (18+ years old)
     */
    public function isEligible(): bool
    {
        return $this->date_of_birth->age >= 18;
    }

    /**
     * Get contractor's age
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Check if contractor is active
     */
    public function isActive(): bool
    {
        return $this->status === true;
    }

    /**
     * Check if contractor is verified
     */
    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    /**
     * Check if contractor can login (verified and active)
     */
    public function canLogin(): bool
    {
        return $this->isVerified() && $this->isActive();
    }

    /**
     * Get the admin who verified this contractor
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * The contractor who referred this contractor
     */
    public function referencedBy()
    {
        return $this->belongsTo(Contractor::class, 'referenced_by');
    }

    /**
     * Contractors referred by this contractor
     */
    public function referrals()
    {
        return $this->hasMany(Contractor::class, 'referenced_by');
    }
        public function orders()
    {
        return $this->hasMany(Order::class, 'user_id','id');
    }
}
