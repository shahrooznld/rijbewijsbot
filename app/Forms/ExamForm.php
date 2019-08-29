<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class ExamForm extends Form
{
    public function buildForm()
    {

        $this->add('name', Field::TEXT);
        $this->add('submit', 'submit', [
            'label' => 'Save',
        ]);

    }
}
