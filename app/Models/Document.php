<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
	protected $appends = ['icon'];

    public function gallery()
    {
        return $this->belongsTo('App\Models\Gallery');
    }

    public function attributes() 
    {
    	return $this->morphTo();
    }

    public function getIconAttribute()
    {
        $icon = '';

        if(!is_null($this->attributes_type)) $icon = Str::lower($this->attributes_type);
        else {
        	
        	$splits = explode('.',$this->filename);
        	$ext = $splits[count($splits)-1];
        	switch(Str::lower($ext)) {
        		case 'doc':
        		case 'docx':
        			$icon = 'word';
        			break;
        		case 'xls':
        		case 'xlsx':
        			$icon = 'excel';
        			break;
        		case 'ppt':
        			$icon = 'ppt';
        			break;
        		case 'pdf':
        			$icon = 'pdf';
        			break;
        		default:
        			$icon = 'document';
        			break;
        	}
        }

        return $icon;
    }
}
