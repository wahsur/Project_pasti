<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanPeminjaman extends Component
{
    public $tanggalMulai, $tanggalSelesai, $tanggalError;
    public $filteredData = [];

    public function cariData()
    {
        $this->tanggalError = null; // reset error dulu

        // Validasi: jika tanggal selesai lebih awal dari tanggal mulai
        if ($this->tanggalMulai && $this->tanggalSelesai) {
            if ($this->tanggalSelesai < $this->tanggalMulai) {
                $this->tanggalError = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
                $this->filteredData = [];
                return;
            }
        }

        $query = Peminjaman::with(['aset', 'user'])
            ->whereIn('status', [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_KEMBALI]);

        if (Auth::user()->jenis !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if ($this->tanggalMulai && $this->tanggalSelesai) {
            $query->whereBetween('tgl_pinjam', [
                Carbon::parse($this->tanggalMulai)->startOfDay(),
                Carbon::parse($this->tanggalSelesai)->endOfDay()
            ]);
        }

        $this->filteredData = $query->latest()->get();
    }

    public function exportPdf()
    {
        $this->tanggalError = null;

        // ✅ Cek apakah tanggal belum diisi
        if (!$this->tanggalMulai || !$this->tanggalSelesai) {
            $this->tanggalError = 'Silakan isi tanggal terlebih dahulu sebelum export.';
            return;
        }

        // ✅ Cek apakah tanggal tidak valid (tanggal selesai < tanggal mulai)
        if ($this->tanggalSelesai < $this->tanggalMulai) {
            $this->tanggalError = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
            return;
        }

        // ✅ Cek apakah data hasil pencarian kosong
        if (empty($this->filteredData) || count($this->filteredData) === 0) {
            $this->tanggalError = 'Tidak ada data di rentan tanggal yang anda pilih';
            return;
        }

        // ✅ Jika semua valid, generate PDF
        $pdf = Pdf::loadView('exports.laporan-peminjaman-pdf', [
            'peminjaman' => $this->filteredData
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan_peminjaman&pengembalian_' . now()->format('Ymd_His') . '.pdf');
    }   


    public function render()
    {
        return view('livewire.admin.laporan-peminjaman')
            ->layout('components.layouts.app')
            ->layoutData(['title' => 'Laporan Peminjaman']);
    }
}
