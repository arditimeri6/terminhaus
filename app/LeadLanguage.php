<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadLanguage extends Model
{
    protected $fillable = [
        'language', 'lead_id'
    ];
}
