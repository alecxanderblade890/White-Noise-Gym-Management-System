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
        'white_noise_id',
        'full_name',
        'payment_method',
        'member_type',
        'gym_access',
        'personal_trainer',
        'payment_amount',
        'purpose_of_visit',
        'staff_assigned',
        'upgrade_gym_access',
        'items_bought',
        'notes',
    ];

    protected $casts = [
        'items_bought' => 'array',
        'purpose_of_visit' => 'array',
    ];

    protected $nullable = [
        'white_noise_id',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'white_noise_id', 'white_noise_id');
    }
}
