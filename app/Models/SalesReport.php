<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    protected $fillable = [
        'date',
        'memberships_only',
        'walk_in_regular_on_sign_up',
        'walk_in_student_on_sign_up',
        'personal_trainer_on_sign_up',
        '1_month_regular',
        '1_month_student',
        '3_months_regular',
        '3_months_student',
        'walk_in_regular',
        'walk_in_student',
        'gym_access_1_month_regular',
        'gym_access_1_month_student',
        'gym_access_3_months_regular',
        'gym_access_3_months_student',
        'personal_trainer_1_month',
        'personal_trainer_walk_in',
        'total_sales',
    ];
}
