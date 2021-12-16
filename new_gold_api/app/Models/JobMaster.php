<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMaster extends Model
{
    use HasFactory;
    public function karigarh()
    {
        return $this->belongsTo('App\Models\Person','karigarh_id');
    }
}
