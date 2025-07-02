<?php

namespace App\Livewire;

use App\Models\Aset;
use Livewire\Component;
use App\Models\Kategori;
use App\Models\Peminjaman;

class StatistikChart extends Component
{
    public $kategoriLabels = [];
    public $kategoriData = [];

    public $bulanLabels = [];
    public $peminjamanData = [];

    public function mount()
    {
        // Pie Chart: Kategori Aset
        $kategori = Kategori::withCount('aset')->get();
        $this->kategoriLabels = $kategori->pluck('nama')->toArray(); // asumsi nama kolom
        $this->kategoriData = $kategori->pluck('aset_count')->toArray();


        // Bar Chart: Peminjaman per Bulan
        $data = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')->orderBy('bulan')->get();

        foreach ($data as $item) {
            $this->bulanLabels[] = date("F", mktime(0, 0, 0, $item->bulan, 10));
            $this->peminjamanData[] = $item->total;
        }
    }

    public function render()
    {
        return view('livewire.statistik-chart');
    }
}

