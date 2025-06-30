<?php

namespace App\Livewire;

use App\Models\Aset;
use Livewire\Component;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DetailComponent extends Component
{
    public $aset, $aset_id;
    public $showModal = false;
    public $jumlah;
    public $tgl_kembali, $tgl_pinjam;
    public function mount($id)
    {
        $this->aset_id = $id;
        $this->aset = Aset::with('kategori')->findOrFail($id);
    }
    public function render()
    {
        $layout = 'components.layouts.user.member';
        if (auth()->check()) {
            $layout = auth()->user()->jenis === 'admin' ? 'components.layouts.app' : 'components.layouts.user.member';
        }
        return view('livewire.user.detail-component')->layout($layout);

    }


    public function openModal()
    {
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->jumlah = null;
        $this->tgl_pinjam = null;
        $this->tgl_kembali = null;
    }

    public function simpanPinjam()
    {
        $this->validate([
            'jumlah' => 'required|numeric|min:1',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // Validasi: maksimal 7 hari setelah tanggal pinjam
        $maxKembali = date('Y-m-d', strtotime($this->tgl_pinjam . '+7 days'));
        if ($this->tgl_kembali > $maxKembali) {
            session()->flash('error', 'Tanggal kembali tidak boleh lebih dari 7 hari setelah tanggal pinjam.');
            return;
        }

        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }

        // Tambahkan validasi stok jika perlu
        if ($this->jumlah > $this->aset->unit_tersedia) {
            $this->addError('jumlah', 'Jumlah melebihi stok tersedia.');
            return;
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'aset_id' => $this->aset_id,
            'jumlah' => $this->jumlah,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_kembali' => $this->tgl_kembali,
            'status' => 'pending',
        ]);



        session()->flash('success', 'Peminjaman berhasil diajukan.');
        return redirect()->route('peminjaman');
    }

}
