<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class QuestionForm extends Form
{
    public function buildForm()
    {
        $this->add('question_nl',Field::TEXTAREA);
        $this->add('question_fa',Field::TEXTAREA);
        $this->add('audio_nl',Field::FILE);
        $this->add('audio_fa',Field::FILE);
        $this->add('image',Field::FILE);
        $this->add('keyboard_answer',Field::TEXTAREA);
        $this->add('correct_answer',Field::TEXT);
        $this->add('submit', 'submit', [
            'label' => 'Save form',
        ]);

    }
}
