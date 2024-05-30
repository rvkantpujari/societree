<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\AccountInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class UpdateAccountInfo extends Component
{
    public AccountInfo $form;

    public function render(Request $request)
    {
        $this->form->email = $request->user()->email;
        $this->form->password = $request->user()->password;
        $this->form->confirm_password = $request->user()->password;

        return view('livewire.profile.update-account-info');
    }

    public function save(Request $request)
    {
        $this->form->save($request);

        return Redirect::route('profile.edit')->with('status', 'account-info-updated');
    }
}
