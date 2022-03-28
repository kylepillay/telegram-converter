<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getInfoAttribute($value)
    {
        return json_decode($value, false, JSON_THROW_ON_ERROR);
    }
}


