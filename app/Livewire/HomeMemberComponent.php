<?php

namespace App\Livewire;

use App\Models\Aset;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Livewire\Component;

class HomeMemberComponent extends Component
{
    public $kategoriSlug = null; // Properti untuk menyimpan slug kategori

    public function render()
    {
        $title = 'Dashboard PASTI';
        $member = User::where('jenis', 'pengguna')->count();
        $aset = Aset::count();
        $pinjam = Peminjaman::where('status', 'dipinjam')->count();
        $kembali = Pengembalian::count();

        // Ambil data kategori
        $kategoris = Kategori::all();

        // Ambil aset berdasarkan kategori (jika ada)
        $asets = $this->kategoriSlug
            ? Aset::whereHas('kategori', function ($query) {
                $query->where('slug', $this->kategoriSlug);
            })->latest()->take(4)->get()
            : Aset::latest()->take(4)->get();

        // Tentukan layout (selalu sama)
        $layout = 'components.layouts.user.member';

        // Kirim data ke view
        return view('livewire.user.home-member-component', [
            'member' => $member,
            'aset' => $aset,
            'pinjam' => $pinjam,
            'kembali' => $kembali,
            'kategoris' => $kategoris,
            'asets' => $asets // Mengirimkan aset (berdasarkan kategori atau semua)
        ])->layout($layout)->layoutData(['title' => $title]);
    }
}
