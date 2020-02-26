<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $keyType = 'string';

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id_5');
    }

    public function assessments()
    {
        return $this->belongsToMany(Assessment::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function legalType()
    {
        return $this->belongsTo(LegalType::class, 'legal_type_id', 'id_3');
    }
}
