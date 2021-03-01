<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    public function materials()
    {
        return $this->hasMany('App\Models\Material');
    }
}
