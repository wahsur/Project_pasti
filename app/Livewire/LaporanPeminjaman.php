<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class LaporanPeminjaman extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';
    public $aset_id, $tgl_pinjam, $tgl_kembali, $status, $peminjaman_id;
    public $aset, $cari;
    public function render()
    {
        $user = Auth::user();
        $statuses = [Peminjaman::STATUS_PENDING, Peminjaman::STATUS_DIPINJAM];

        if ($user->jenis === 'admin') {
            $peminjaman = Peminjaman::with('aset', 'user')
                ->whereIn('status', $statuses)
                ->when($this->cari, function ($query) {
                    $query->whereHas('aset', function ($q) {
                        $q->where('namaAset', 'like', '%' . $this->cari . '%');
                    });
                })
                ->latest()
                ->paginate(10);
        } else {
            $peminjaman = Peminjaman::with('aset')
                ->where('user_id', $user->id)
                ->when($this->cari, function ($query) {
                    $query->whereHas('aset', function ($q) {
                        $q->where('namaAset', 'like', '%' . $this->cari . '%');
                    });
                })
                ->latest()
                ->paginate(10);
        }

        $layout = $user->jenis === 'pengguna'
            ? 'components.layouts.user.member'
            : 'components.layouts.app';

        return view('livewire.admin.laporan-peminjaman', [
            'peminjaman' => $peminjaman,
            'aset' => $this->aset,
        ])->layout($layout)->layoutData(['title' => 'Peminjaman']);
    }
}
