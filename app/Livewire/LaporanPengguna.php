<?php

namespace App\Livewire;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $member= User::where('jenis', 'pengguna')->paginate(10);
        $layout['title'] = 'Laporan Pengguna';
        return view('livewire.admin.laporan-pengguna', ['member' => $member])->layoutData($layout);
    }

    public function exportPdf()
    {
        $member = User::where('jenis', 'pengguna')->get();

        $pdf = Pdf::loadView('exports.laporan-pengguna-pdf', [
            'member' => $member
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan_pengguna' . now()->format('Ymd_His') . '.pdf');
    }   
}
