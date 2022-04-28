<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legend extends Model
{
    protected $fillable = [
        'img_url', 'name', 'description',
        'origin_province', 'origin_date',
    ];
}
