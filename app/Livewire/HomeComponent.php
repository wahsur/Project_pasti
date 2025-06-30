<?php

namespace App\Livewire;

use App\Models\Aset;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $title = 'Dashboard PASTI';
        $memberCount = User::where('jenis', 'pengguna')->count();
        $asetCount = Aset::count();
        $pinjamCount = Peminjaman::where('status', 'dipinjam')->count();
        $kembaliCount = Pengembalian::count();
        $peminjamanQuery = Peminjaman::with(['user', 'aset'])->latest()->where('status', ['dipinjam', 'pending', 'ditolak']);
        if (auth()->user()->jenis !== 'admin') {
            // Jika bukan admin, batasi data hanya milik user yang login
            $peminjamanQuery->where('user_id', auth()->id());
        }
        $peminjaman = $peminjamanQuery->take(5)->get();

        $topPeminjam = Peminjaman::select('user_id')
            ->with('user')
            ->whereIn('status', ['dipinjam', 'kembali'])
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(*) as jumlah_pinjam')
            ->orderByDesc('jumlah_pinjam')
            ->take(5)
            ->get()
            ->map(function ($data) {
                $data->nama = $data->user->nama ?? 'Tidak Diketahui';
                return $data;
            });

        $layout = auth()->user()->jenis === 'pengguna'
            ? 'components.layouts.user.member'
            : 'components.layouts.app';

        return view('livewire.admin.home-component', [
            'member' => $memberCount,
            'aset' => $asetCount,
            'pinjam' => $pinjamCount,
            'kembali' => $kembaliCount,
            'peminjaman' => $peminjaman,
            'topPeminjam' => $topPeminjam
        ])->layout($layout)->layoutData(['title' => $title]);
    }

}
