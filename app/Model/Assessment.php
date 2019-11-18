<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $keyType = 'string';

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function hasEmissions12()
    {
        return $this->total_scope_1 > 0.0 || $this->total_scope_2 > 0.0;
    }

    public function hasReductions()
    {
        return ($this->reductions_scope_1_2 ?? 0.0 > 0.0) || ($this->reductions_scope_1 ?? 0.0 > 0.0) || ($this->reductions_scope_2 ?? 0.0 > 0.0) || ($this->reductions_scope_3 ?? 0.0 > 0.0);
    }

    public function sumReductions()
    {
        return ($this->reductions_scope_1_2 ?? 0.0) + ($this->reductions_scope_1 ?? 0.0) + ($this->reductions_scope_2 ?? 0.0) + ($this->reductions_scope_3 ?? 0.0);
    }
}
