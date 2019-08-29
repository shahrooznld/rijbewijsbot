<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class SendToAllForm extends Form
{
    public function buildForm()
    {

        $this->add('SendToAll', Field::TEXT);
        $this->add('submit', 'submit', [
            'label' => 'Save',
        ]);

    }
}
