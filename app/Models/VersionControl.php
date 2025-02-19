<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersionControl extends Model
{
    protected $table = 'version_controls';
    protected $fillable = [
        'version_control',
        'app_link',
    ];
}
