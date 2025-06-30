<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\User;

class UserComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = "bootstrap";

    public $nama, $email, $password, $id, $cari;

    public function render()
    {
        $layout['title'] = "Kelola User";
        if ($this->cari != "") {
            $data['user'] = User::where('jenis', 'admin')->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->cari . '%');
            })->paginate(10);
        } else {
            $data['user'] = User::where('jenis', 'admin')->paginate(2);
        }
        return view('livewire.admin.user-component', $data)->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required'
        ], [
            'nama.required' => 'nama tidak boleh kosong!',
            'email.required' => 'email salah tidak boleh kosong!',
            'password.required' => 'password tidak boleh kosong!'
        ]);

        // Contoh simpan ke database (opsional)
        User::create([
            'nama' => $this->nama, // atau 'nama' => $this->nama jika nama kolom kamu "nama"
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'jenis' => 'admin'
        ]);

        session()->flash('success', 'User berhasil ditambahkan!');
        return redirect()->route('user');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->id = $user->id;
    }

    public function update()
    {
        $user = User::find($this->id);

        if (empty($this->password)) {
            $user->update([
                'nama' => $this->nama,
                'email' => $this->email
            ]);
        } else {
            $user->update([
                'nama' => $this->nama,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
        }

        session()->flash('success', 'User berhasil diubah!');
        $this->reset();
    }

    public function confirmDelete($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        $user = User::find($this->id);
        $user->delete();
        session()->flash('success', 'User berhasil dihapus!');
        $this->reset();
    }
}
