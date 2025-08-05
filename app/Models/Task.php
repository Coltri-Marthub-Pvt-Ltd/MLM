<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'due_date',
        'completed_at',
        'assigned_to',
        'assigned_by',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_by');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('completed', false);
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return $this->due_date && 
               $this->due_date < now()->toDateString() && 
               !$this->completed;
    }

    public function getStatusColorAttribute()
    {
        return $this->completed ? 'success' : 'secondary';
    }

    public function getStatusTextAttribute()
    {
        return $this->completed ? 'Completed' : 'Pending';
    }

    // Mutators
    public function setCompletedAttribute($value)
    {
        $this->attributes['completed'] = $value;
        
        // Auto-set completed_at when task is marked as completed
        if ($value && !$this->completed_at) {
            $this->attributes['completed_at'] = now();
        } elseif (!$value) {
            $this->attributes['completed_at'] = null;
        }
    }
}
