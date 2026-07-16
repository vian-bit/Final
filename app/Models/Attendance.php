<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
        'original_check_in',
        'original_check_out',
        'edited_by',
        'edited_at',
        'edit_reason',
    ];

    protected $casts = [
        'date'      => 'date',
        'edited_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
