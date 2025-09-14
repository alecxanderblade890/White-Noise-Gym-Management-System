<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'white_noise_id',
        'full_name',
        'photo_url',
        'membership_term_gym_access',
        'member_type',
        'with_pt',
        'pt_start_date',
        'pt_end_date',
        'membership_term_billing_rate',
        'with_pt_billing_rate',
        'membership_start_date',
        'membership_end_date',
        'gym_access_start_date',
        'gym_access_end_date',
        'address',
        'date_of_birth',
        'id_presented',
        'id_number',
        'email',
        'phone_number',
        'emergency_contact_person',
        'emergency_contact_number',
        'weight_kg',
        'height_cm',
        'notes',
        'payment_history',
    ];

    protected $casts = [
        'payment_history' => 'array',
    ];

    public function dailyLogs(): HasMany
    {
        return $this->hasMany(DailyLog::class);
    }
}
