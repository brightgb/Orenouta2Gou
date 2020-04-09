<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SongUserAction extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
}