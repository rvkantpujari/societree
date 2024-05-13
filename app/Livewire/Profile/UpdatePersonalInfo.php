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
        $this->form->email = $request->user()->email;
        $this->hasVerifiedEmail = $request->user()->hasVerifiedEmail();
        $this->user = $request->user();

        return view('livewire.profile.update-personal-info');
    }

    public function save(Request $request)
    {
        $request->user()->fill($this->form->validate());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $this->form->reset();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
