<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\PersonalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdatePersonalInfo extends Component
{
    use WithFileUploads;

    public PersonalInfo $form;

    public function render(Request $request)
    {
        $this->form->first_name = $request->user()->first_name;
        $this->form->middle_name = $request->user()->middle_name;
        $this->form->last_name = $request->user()->last_name;
        $this->form->dob = $request->user()->dob;
        $this->form->phone = $request->user()->phone;

        return view('livewire.profile.update-personal-info');
    }

    public function save(Request $request)
    {
        $this->form->save($request);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
