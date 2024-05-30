<?php

namespace App\Livewire\Forms;

use Illuminate\Http\Request;
use Livewire\Form;

class AccountInfo extends Form
{
    public $email;
    public $password;
    public $confirm_password;

    public function save(Request $request)
    {
        $request->user()->fill($this->validate([
            'email' => ['email'],
            'password' => ['string'],
            'confirm_password' => ['same:password'],
        ]));

        $request->user()->save();

        $this->reset();
    }
}
