<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
    	'title', 'survey_id', 'type', 'options'
    ];

    public static $type = ["textarea", 'text', 'radio', 'checkbox'];

    public function getOptionsAttribute($value)
    {
    	return !empty($value) ? explode(",", $value) : null;
    }

    public function setOptionsAttribute($value)
    {
    	$this->attributes['options'] = !empty($value) ? implode(",", $value) : null;
    }

    public function survey()
    {
    	return $this->belongsTo(Survey::class);
    }
}
