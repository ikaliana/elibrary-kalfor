<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $attributes = [
        'visibility' => 1,
    ];

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
