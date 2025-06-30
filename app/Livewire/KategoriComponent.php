<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class KategoriComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = "bootstrap";
    public $nama, $id, $deskripsi, $cari;
    public function render()
    {
        if ($this->cari != "") {
            $data['kategori'] = Kategori::where('nama', 'like', '%' . $this->cari . '%')->paginate(10);
        } else {
            $data['kategori'] = Kategori::paginate(10);
        }

        $layout['title'] = 'Kelola Kategori';
        return view('livewire.admin.kategori-component', $data)->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
        ], [
            'nama.required' => 'nama tidak boleh kosong!',
            'deskripsi.required' => 'deksripsi tidak boleh kosong!',
        ]);

        // Contoh simpan ke database (opsional)
        Kategori::create([
            'nama' => $this->nama, // atau 'nama' => $this->nama jika nama kolom kamu "nama"
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('success', 'Kategori berhasil ditambahkan!');
        return redirect()->route('kategori');
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        $this->nama = $kategori->nama;
        $this->deskripsi = $kategori->deskripsi;
        $this->id = $kategori->id;
    }

    public function update()
    {
        $kategori = Kategori::find($this->id);

        $kategori->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi
        ]);

        session()->flash('success', 'Kategori berhasil diubah!');
        $this->reset();
    }

    public function confirmDelete($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        $kategori = Kategori::find($this->id);
        $kategori->delete();
        session()->flash('success', 'Kategori berhasil dihapus!');
        $this->reset();
    }
}
