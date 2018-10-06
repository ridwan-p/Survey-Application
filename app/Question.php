<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
    	'title', 'survey_id', 'type', 'option'
    ];

    public function survey()
    {
    	return $this->belongsTo(Survey::class);
    }
}
