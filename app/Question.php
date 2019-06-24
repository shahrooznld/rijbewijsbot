<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'is_free' => 'boolean'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
