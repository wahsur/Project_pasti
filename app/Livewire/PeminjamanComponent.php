<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\Peminjaman;
use App\Models\Aset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PeminjamanComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';

    public $aset_id, $tgl_pinjam, $tgl_kembali, $status, $peminjaman_id, $jumlah;
    public $aset, $cari;

    public function mount()
    {
        // Ambil data aset untuk dropdown
        $this->aset = Aset::where('unit_tersedia', '>', 0)->get();
    }

    public function render()
    {
        $query = Peminjaman::with('aset');
        if (!empty($this->cari)) {
            $query->WhereHas('aset', function ($k) {
                $k->where('namaAset', 'like', '%' . $this->cari . '%');
            });
        }

        $user = Auth::user();
        $statuses = [Peminjaman::STATUS_PENDING, Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_DITOLAK];

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
                ->whereIn('status', $statuses)
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
            ? 'components.layouts.profile'
            : 'components.layouts.app';

        return view('livewire.peminjaman-component', [
            'peminjaman' => $peminjaman,
            'aset' => $this->aset,
        ])->layout($layout)->layoutData(['title' => 'Peminjaman']);
    }


    public function store()
    {
        $this->validate([
            'jumlah' => 'required|numeric|min:1',
            'aset_id' => 'required|exists:asets,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // Validasi: maksimal 7 hari setelah tanggal pinjam
        $maxKembali = date('Y-m-d', strtotime($this->tgl_pinjam . '+7 days'));
        if ($this->tgl_kembali > $maxKembali) {
            session()->flash('error', 'Tanggal kembali tidak boleh lebih dari 7 hari setelah tanggal pinjam.');
            return;
        }

        Peminjaman::create([
            'jumlah' => $this->jumlah,
            'aset_id' => $this->aset_id,
            'user_id' => Auth::id(),
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => Peminjaman::STATUS_PENDING,
        ]);

        session()->flash('success', 'Peminjaman berhasil diajukan.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $this->peminjaman_id = $id;
        $this->jumlah = $peminjaman->jumlah;
        $this->aset_id = $peminjaman->aset_id;
        $this->tgl_pinjam = $peminjaman->tgl_pinjam;
        $this->tgl_kembali = $peminjaman->tgl_kembali;
        $this->status = $peminjaman->status;
    }

    public function update()
    {

        $this->validate([
            'jumlah' => 'required|numeric|min:1',
            'aset_id' => 'required|exists:asets,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'status' => [
                'required',
                Rule::in([
                    Peminjaman::STATUS_PENDING,
                    Peminjaman::STATUS_DIPINJAM,
                    Peminjaman::STATUS_KEMBALI,
                    Peminjaman::STATUS_DITOLAK
                ]),
            ],
        ]);

        $peminjaman = Peminjaman::findOrFail($this->peminjaman_id);
        $peminjaman->update([
            'jumlah' => $this->jumlah,
            'aset_id' => $this->aset_id,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => $this->status,
        ]);

        // Jika status diubah menjadi kembali, tambah unit tersedia
        if ($this->status === Peminjaman::STATUS_KEMBALI) {
            $peminjaman->aset->increment('unit_tersedia', $peminjaman->jumlah);
        }
        // Jika status diubah menjadi dipinjam, kurangi unit tersedia
        if ($this->status === Peminjaman::STATUS_DIPINJAM) {
            $peminjaman->aset->decrement('unit_tersedia', $peminjaman->jumlah);
        }

        session()->flash('success', 'Data peminjaman berhasil diperbarui.');
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->peminjaman_id = $id;
    }

    public function delete()
    {

        $peminjaman = Peminjaman::findOrFail($this->peminjaman_id);

        if (
            $peminjaman->status === Peminjaman::STATUS_DIPINJAM &&
            $peminjaman->user &&
            $peminjaman->aset
        ) {
            session()->flash('error', 'Tidak bisa menghapus peminjaman yang sedang dipinjam!');
            return;
        }

        $peminjaman->delete();

        session()->flash('success', 'Data peminjaman berhasil dihapus.');
        $this->resetForm();
    }


    public function setStatus($id, $status)
    {
        if (Auth::user()->jenis !== 'admin') {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengubah status!');
            return;
        }

        if (!Peminjaman::validateStatus($status)) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => $status]);

        if ($status === Peminjaman::STATUS_KEMBALI) {
            $peminjaman->aset->increment('unit_tersedia', $peminjaman->jumlah);
        }

        session()->flash('success', 'Status peminjaman diperbarui.');
    }


    public function resetForm()
    {
        $this->peminjaman_id = null;
        $this->aset_id = null;
        $this->tgl_pinjam = null;
        $this->tgl_kembali = null;
        $this->status = null;
    }
}
