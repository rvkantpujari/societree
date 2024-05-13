<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PersonalInfo extends Form
{
    #[Validate('required|min:2|max:50')]
    public $first_name;

    #[Validate('max:50')]
    public $middle_name;

    #[Validate('required|min:2|max:50')]
    public $last_name;

    #[Validate('required|email|max:255')]
    public $email;
}
