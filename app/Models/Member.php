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
        'full_name',
        'photo_url',
        'payment_date_membership',
        'membership_term_gym_access',
        'start_date',
        'end_date',
        'billing_rate',
        'payment_date_gym_access',
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
    ];

    public function dailyLogs(): HasMany
    {
        return $this->hasMany(DailyLog::class);
    }
}
