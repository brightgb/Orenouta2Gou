<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    protected $guarded = [];
    protected $dates = ['notify_date', 'created_at', 'updated_at'];
}