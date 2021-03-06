<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'is_free' => 'boolean',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('answer');
    }
    public function exams()
    {
        return $this->belongsToMany(Exam::class)->orderBy('order')->withTimestamps()->withPivot('order');
    }

    public function getKeyboardAttribute()
    {

        $answer = collect([$this->answer_1, $this->answer_2, $this->answer_3])->filter();
        if (count($answer)) {
            return count($answer) == 2 ? ['1', '2'] : ['1', '2', '3'];
        }

        return $this->correct_answer == 'Yes' || $this->correct_answer == 'No' ? ['Yes', 'No'] : ['جواب سوال را وارد کنید'];

    }

    public function getTextAnswerAttribute()
    {
        $answer = collect([$this->answer_1, $this->answer_2, $this->answer_3])->filter();
        if (count($answer)) {
            return count($answer) == 2 ? "\n1) ".$this->answer_1."\n2) ".$this->answer_2 : "\n1) ".$this->answer_1."\n2) ".$this->answer_2."\n3) ".$this->answer_3;
        }

        return $this->correct_answer == 'Yes' || $this->correct_answer == 'No' ? "\n1) "."Yes"."\n2) "."No" : 'جواب سوال را وارد کنید';


    }

    public function getTextAnswerFAAttribute()
    {
        $answer = collect([$this->answer_1_fa, $this->answer_2_fa, $this->answer_3_fa])->filter();
        if (count($answer)) {
            return count($answer) == 2 ? "\n1) ".$this->answer_1_fa."\n2) ".$this->answer_2_fa : "\n1) ".$this->answer_1_fa."\n2) ".$this->answer_2_fa."\n3) ".$this->answer_3_fa;
        }

        return $this->correct_answer == 'Yes' || $this->correct_answer == 'No' ? "\n1) "."بله"."\n2) "."خیر" : 'جواب سوال را وارد کنید';


    }

    public function scopeFree($query)
    {
        return $query->where('is_free', 1);
    }
}
