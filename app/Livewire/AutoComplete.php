<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class AutoComplete extends Component
{
    public function render()
    {
        $roles = Role::all();
        $user_roles = Auth::user()->roles->pluck('name');
        return view('livewire.auto-complete', ['roles' => $user_roles, 'results' => $roles]);
    }
}
