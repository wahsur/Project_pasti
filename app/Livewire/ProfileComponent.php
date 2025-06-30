<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileComponent extends Component
{
    public $nama, $email, $telepon, $alamat, $password;
    public $userId;

    public function mount()
    {
        $user = Auth::user();
        $this->userId = $user->id;
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->telepon = $user->telepon;
        $this->alamat = $user->alamat;
    }

    public function render()
    {
        $layout['title'] = 'Profil Saya';
        return view('livewire.profile-component')->layout('components.layouts.profile')->layoutData($layout);
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
        ]);

        session()->flash('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->password = null;
        session()->flash('success', 'Password berhasil diperbarui!');
    }
}
