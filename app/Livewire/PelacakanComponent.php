<?php

namespace App\Livewire;

use App\Models\Aset;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PelacakanComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = "bootstrap";

    public $cari;

    public function render()
    {
        $query = Aset::with('kategori'); // eager load relasi kategori

        if (!empty($this->cari)) {
            $query->where(function ($q) {
                $q->where('namaAset', 'like', '%' . $this->cari . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->cari . '%')
                    ->orWhere('kodeAset', 'like', '%' . $this->cari . '%')
                    ->orWhereHas('kategori', function ($k) {
                        $k->where('nama', 'like', '%' . $this->cari . '%');
                    });
            });
        }

        $asets = $query->latest()->take(6)->get();

        $layout = auth()->user()->jenis === 'pengguna'
            ? 'components.layouts.user.member'
            : 'components.layouts.app';

        return view('livewire.pelacakan-component', [
            'asets' => $asets
        ])->layout($layout)->layoutData(['title' => 'Pelacakan Aset']);
    }
}
