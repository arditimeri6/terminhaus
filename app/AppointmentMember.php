<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentMember extends Model
{
    protected $fillable = [
        'salutation', 'first_name', 'krankenkassen', 'birth_year', 'contract_duration', 'behandlung', 'appointment_id'
    ];
}
