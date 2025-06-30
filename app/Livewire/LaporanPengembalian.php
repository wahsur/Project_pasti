<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class LaporanPengembalian extends Component
{
     use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = "bootstrap";

    public $id, $pinjam_id, $tgl_kembali, $denda, $namaAset, $user, $lama, $status;

    public function render()
    {
        if (auth()->user()->jenis === 'admin') {
            $data['peminjaman'] = Peminjaman::with(['user', 'aset'])
                ->where('status', 'dipinjam')
                ->paginate(5);
            $data['pengembalian'] = Pengembalian::paginate(5);
        } else {
            $userId = auth()->id();
            $data['peminjaman'] = Peminjaman::with(['user', 'aset'])
                ->where('status', 'dipinjam')
                ->where('user_id', $userId)
                ->paginate(5);

            $data['pengembalian'] = Pengembalian::whereHas('peminjaman', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate(5);
        }
        $layout = auth()->user()->jenis === 'pengguna'
            ? 'components.layouts.member'
            : 'components.layouts.app';
        return view('livewire.admin.laporan-pengembalian', $data)->layout($layout)
            ->layoutData(['title' => 'Pengembalian']);
    }
}
