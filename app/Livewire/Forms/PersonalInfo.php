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

    #[Validate('date')]
    public $dob;

    #[Validate('nullable|string|max:15')]
    public $phone;

    public function save($request)
    {
        $request->user()->fill($this->validate());

        $request->user()->save();

        $this->reset();
    }
}
