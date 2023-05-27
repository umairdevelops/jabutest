<?php

namespace App\Http\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\WithToasts;
use WireUi\Traits\WithToastsConfig;


class Login extends Component
{
    public $email;
    public $password;


    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];


    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (Auth::attempt($credentials)) {
            redirect()->route('/');
        } else {
            $this->addError('login', 'Incorrect credentials');
        }
    }

    public function render()
    {
        return view('livewire.login.login');
    }
}
