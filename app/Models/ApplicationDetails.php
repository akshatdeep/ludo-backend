<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDetails extends Model
{
    protected $table = 'application_details';
    protected $guarded = ['id'];

    public function updated_by()
    {
        return $this->hasOne('App\User', 'id','updated_by');
    }
}
