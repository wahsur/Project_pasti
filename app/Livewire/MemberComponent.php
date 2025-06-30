<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MemberComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = "bootstrap";
    public $nama, $telepon, $email, $password, $alamat, $id, $cari;
    public function render()
    {
        if ($this->cari != "") {
            $data['member'] = User::where('jenis', 'pengguna')
                ->where(function ($query) {
                    $query->where('nama', 'like', '%' . $this->cari . '%')
                        ->orWhere('email', 'like', '%' . $this->cari . '%');
                })
                ->paginate(10);
        } else {
            $data['member'] = User::where('jenis', 'pengguna')->paginate(10);
        }
        $layout['title'] = 'Kelola Pengguna';
        return view('livewire.admin.member-component', $data)->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong',
            'telepon. required' => 'Telepon harus diisi',
            'alamat.required' => 'Alamat tidak boleh kosong'
        ]);
        User::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
            'jenis' => 'pengguna'
        ]);

        session()->flash('success', 'Data berhasil ditambahkan!');
        return redirect()->route('member');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->telepon = $user->telepon;
        $this->alamat = $user->alamat;
        $this->id = $user->id;
    }

    public function update()
    {
        $user = User::find($this->id);

        $user->update([
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
        ]);

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
