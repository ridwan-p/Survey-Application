<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
    	'title', 'description'
    ];

    public function questions()
    {
    	return $this->hasMany(Question::class);
    }
}
