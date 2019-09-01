<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class UserForm extends Form
{
    public function buildForm()
    {
        $this->add('first_name', Field::TEXT);
        $this->add('last_name', Field::TEXT);
        $this->add('telegram_username', Field::TEXT);
        $this->add('telegram_user_id', Field::TEXT);
        $this->add('active_exam_id', Field::TEXT);
        $this->add('active_question_order', Field::TEXT);
        $this->add('submit', 'submit', [
            'label' => 'Save',
        ]);

    }
}
