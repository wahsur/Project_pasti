<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email, $password;

    public function render()
    {
        $layout['title'] = 'Login';
        return view('livewire.login-component')->layout('components.layouts.login')->layoutData($layout);
    }

    public function proses()
    {
        // Validasi hanya email (password tidak diperlukan di tahap awal)
        $this->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Email tidak ditemukan.');
            return;
        }

        // Jika role pengguna (tanpa password)
        if ($user->jenis === 'pengguna') {
            Auth::login($user);
            session()->regenerate();
            return redirect()->route('home_member');
        }

        // Jika bukan role pengguna, maka validasi password
        $this->validate([
            'password' => 'required',
        ], [
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        // Otentikasi standar
        if (
            Auth::guard('web')->attempt([
                'email' => $this->email,
                'password' => $this->password,
            ])
        ) {
            session()->regenerate();
            return redirect()->route('home');
        }

        $this->addError('email', 'Autentikasi gagal.');
    }

}
