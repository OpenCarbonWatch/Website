<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $keyType = 'string';

    public function assessments()
    {
        return $this->belongsToMany(Assessment::class);
    }

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }
}
