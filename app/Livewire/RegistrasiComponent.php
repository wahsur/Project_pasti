<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RegistrasiComponent extends Component
{
    public $nama;
    public $email;
    public $telepon;
    public $remember = false; // optional

    protected $rules = [
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'telepon' => 'required|string|max:15',
    ];

    public function register()
    {
        $this->validate();

        // Buat user baru
        $user = User::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'jenis' => 'pengguna', // set role sebagai pengguna
        ]);

        // Kirim email notifikasi ke user
        Mail::to($this->email)->send(new \App\Mail\WelcomeUserMail($user));

        // Reset form / kirim pesan sukses
        session()->flash('success', 'Registrasi berhasil! Cek email Anda untuk konfirmasi. Silahkan Melakukan Login');
        $this->reset(['nama', 'email', 'telepon', 'remember']);
        return redirect()->route('login');
    }

    public function render()
    {
        $layout['title'] = 'Registrasi';
        return view('livewire.registrasi-component')->layout('components.layouts.registrasi')->layoutData($layout);
    }
}
