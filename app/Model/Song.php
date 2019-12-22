<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
}