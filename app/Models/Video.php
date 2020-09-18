<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $timestamps = false;

    public function document()
    {
        return $this->morphOne('App\Models\Document', 'attributes');
    }
}
