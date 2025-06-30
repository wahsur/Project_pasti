<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use DateTime;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class KembaliComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = "bootstrap";

    public $id, $pinjam_id, $tgl_kembali, $denda, $namaAset, $user, $lama, $status;

    public function render()
    {
        if (auth()->user()->jenis === 'admin') {
            $data['peminjaman'] = Peminjaman::with(['user', 'aset'])
                ->where('status', 'dipinjam')
                ->latest()
                ->paginate(5);
            $data['pengembalian'] = Pengembalian::latest()->paginate(5);
        } else {
            $userId = auth()->id();
            $data['peminjaman'] = Peminjaman::with(['user', 'aset'])
                ->where('status', 'dipinjam')
                ->where('user_id', $userId)
                ->latest()
                ->paginate(5);

            $data['pengembalian'] = Pengembalian::whereHas('peminjaman', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->latest()->paginate(5);
        }
        $layout = auth()->user()->jenis === 'pengguna'
            ? 'components.layouts.profile'
            : 'components.layouts.app';
        return view('livewire.kembali-component', $data)->layout($layout)
            ->layoutData(['title' => 'Pengembalian']);
    }

    public function pilih($id)
    {
        $peminjaman = Peminjaman::find($id);
        $this->namaAset = $peminjaman->aset->namaAset;
        $this->user = $peminjaman->user->nama;
        $this->tgl_kembali = $peminjaman->tgl_kembali;
        $this->pinjam_id = $peminjaman->id;

        $kembali = new DateTime($this->tgl_kembali);
        $today = new DateTime();
        $selisih = $today->diff($kembali);

        if ($selisih->invert == 1) {
            // Tanggal kembali sudah lewat → Terlambat
            $this->status = true;
            $this->lama = $selisih->days;
        } else {
            // Belum lewat → Belum terlambat
            $this->status = false;
            $this->lama = 0; // ← VALIDASI DITAMBAHKAN DI SINI
        }
    }

    public function store()
    {
        if ($this->status == true) {
            $denda = $this->lama * 1000;
        } else {
            $denda = 0;
        }
        $peminjaman = Peminjaman::find($this->pinjam_id);

        Pengembalian::create([
            'peminjaman_id' => $this->pinjam_id,
            'tgl_kembali' => date('Y-m-d'),
            'denda' => $denda,
        ]);
        $peminjaman->update([
            'status' => Peminjaman::STATUS_KEMBALI
        ]);
        if ($peminjaman->aset) {
            $peminjaman->aset->increment('unit_tersedia', $peminjaman->jumlah);
        }
        $this->reset();
        session()->flash('success', 'Data berhasil disimpan!');
        return redirect()->route('kembali');

    }
}
