<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class QuestionForm extends Form
{
    public function buildForm()
    {
        $this->add('question_nl', Field::TEXTAREA);
        $this->add('question_fa', Field::TEXTAREA);
        $this->add('answer_1', Field::TEXT);
        $this->add('answer_2', Field::TEXT);
        $this->add('answer_3', Field::TEXT);
        $this->add('answer_4', Field::TEXT);
        $this->add('correct_answer', Field::TEXT, [
            'choices' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                'Yes' => 'Yes',
                'No' => 'No',
            ],
        ]);
        $this->add('is_free', Field::CHOICE, [
            'choices' => [
                '0' => 'Not Free',
                '1' => 'Free',
            ],
        ]);
        $this->add('description_nl', Field::TEXTAREA);
        $this->add('description_fa', Field::TEXTAREA);
        $this->add('submit', 'submit', [
            'label' => 'Save',
        ]);

    }
}
