<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //
    protected $guarded = [];

    public function questions() {
        return $this->belongsToMany(Question::class)->orderBy('order','asc')->withTimestamps()->withPivot('order')->free();
    }
}
