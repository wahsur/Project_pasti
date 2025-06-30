<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class LaporanPengguna extends Component
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
        return view('livewire.admin.laporan-pengguna', $data)->layoutData($layout);
    }
}
