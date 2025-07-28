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
        'membership_term_gym_access',
        'payment_method',
        'payment_amount',
        'purpose_of_visit',
        'staff_assigned',
        'upgrade_gym_access',
        'notes',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
