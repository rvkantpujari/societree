<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\PersonalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class UpdatePersonalInfo extends Component
{
    public PersonalInfo $form;
    public $hasVerifiedEmail = '';
    public $user = '';

    public function render(Request $request)
    {
        $this->form->first_name = $request->user()->first_name;
        $this->form->middle_name = $request->user()->middle_name;
        $this->form->last_name = $request->user()->last_name;
        $this->form->dob = $request->user()->dob;

        return view('livewire.profile.update-personal-info');
    }

    public function save(Request $request)
    {
        $request->user()->fill($this->form->validate());
        $request->user()->save();

        $this->form->reset();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
