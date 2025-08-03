<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyLog extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'date',
        'time_in',
        'time_out',
        'member_id',
        'full_name',
        'payment_method',
        'payment_amount',
        'purpose_of_visit',
        'staff_assigned',
        'upgrade_gym_access',
        'notes',
    ];

    protected $casts = [
        'member_id' => 'integer',
    ];

    protected $nullable = [
        'member_id',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
