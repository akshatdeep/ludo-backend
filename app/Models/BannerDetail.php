<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerDetail extends Model
{
    protected $table = 'banner_details';
    protected $fillable = [
        'category',
        'image',
        'status'
    ];
}
