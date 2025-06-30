<?php

namespace App\Livewire;

use App\Models\Aset;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class AsetComponent extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public $id, $kodeAset, $namaAset, $kategori, $jumlah, $unit_tersedia,
    $ruangan, $status, $deskripsi, $foto, $foto_lama, $cari, $kategoriList;

    public function mount()
    {
        $this->kategoriList = Kategori::all(); // Untuk dropdown kategori
    }

    public function render()
    {
        $data['aset'] = $this->cari
            ? Aset::where('namaAset', 'like', '%' . $this->cari . '%')->paginate(10)
            : Aset::paginate(10);

        $data['kategoriList'] = $this->kategoriList;
        $layout = auth()->user()->jenis === 'pengguna'
            ? 'components.layouts.user.member'
            : 'components.layouts.app';

        return view('livewire.admin.aset-component', $data)->layout($layout)->layoutData([
            'title' => 'Kelola Aset'
        ]);
    }

    public function store()
    {
        $this->validate([
            'namaAset' => 'required',
            'kategori' => 'required|integer|exists:kategoris,id',
            'jumlah' => 'required|integer|min:1',
            'unit_tersedia' => 'required|integer|min:0|lte:jumlah',
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'kategori.required' => 'Kategori harus diisi!',
            'unit_tersedia.lte' => 'Unit tersedia tidak boleh lebih dari jumlah!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, jpg, atau png!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
        ]);

        // Ambil kategori
        $kategoriModel = Kategori::find($this->kategori);

        // Buat kodeAset otomatis: huruf pertama dari kategori + random 4 digit
        $prefix = strtoupper(substr($kategoriModel->nama, 0, 3)); // contoh: 'KOM'
        $kodeAset = $prefix . '-' . random_int(100, 999);       // contoh: 'K-837'

        // Upload gambar
        $namaFile = null;
        if ($this->foto) {
            $namaFile = 'aset/' . time() . '_' . $this->foto->getClientOriginalName();
            $this->foto->storeAs('aset', basename($namaFile), 'public');
        }

        Aset::create([
            'kodeAset' => $kodeAset,
            'namaAset' => $this->namaAset,
            'kategori_id' => $this->kategori,
            'jumlah' => $this->jumlah,
            'unit_tersedia' => $this->unit_tersedia,
            'ruangan' => $this->ruangan,
            'status' => $this->status,
            'deskripsi' => $this->deskripsi,
            'foto' => $namaFile,
        ]);

        $this->reset(['kodeAset', 'namaAset', 'kategori', 'jumlah', 'unit_tersedia', 'ruangan', 'status', 'deskripsi', 'foto']);
        session()->flash('success', 'Data berhasil ditambahkan!');
        return redirect()->route('aset');
    }


    public function edit($id)
    {
        $aset = Aset::findOrFail($id);

        $this->id = $aset->id;
        $this->kodeAset = $aset->kodeAset;
        $this->namaAset = $aset->namaAset;
        $this->kategori = $aset->kategori_id;
        $this->jumlah = $aset->jumlah;
        $this->unit_tersedia = $aset->unit_tersedia;
        $this->ruangan = $aset->ruangan;
        $this->status = $aset->status;
        $this->deskripsi = $aset->deskripsi;
        $this->foto_lama = $aset->foto; // Simpan foto lama
        $this->foto = null; // Reset foto input
    }

    public function update()
    {
        $this->validate([
            'kodeAset' => 'nullable', // Diubah dari required karena akan digenerate ulang jika kategori berubah
            'namaAset' => 'required',
            'kategori' => 'required|integer|exists:kategoris,id',
            'jumlah' => 'required|integer|min:1',
            'unit_tersedia' => 'required|integer|min:0|lte:jumlah',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'unit_tersedia.lte' => 'Unit tersedia tidak boleh lebih dari jumlah!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, jpg, atau png!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
        ]);

        $aset = Aset::findOrFail($this->id);

        // ✅ Ganti kodeAset jika kategori diubah
        if ($this->kategori != $aset->kategori_id) {
            $kategoriModel = Kategori::find($this->kategori);
            $prefix = strtoupper(substr($kategoriModel->nama, 0, 3)); // Ambil 3 huruf pertama nama kategori
            $this->kodeAset = $prefix . '-' . rand(100, 999); // Contoh hasil: KOM-341
        }

        // ✅ Cek dan simpan foto baru jika diunggah
        $namaFile = $this->foto_lama;
        if ($this->foto && is_object($this->foto)) {
            // Hapus foto lama jika ada
            if ($this->foto_lama && Storage::disk('public')->exists($this->foto_lama)) {
                Storage::disk('public')->delete($this->foto_lama);
            }

            // Simpan foto baru
            $namaFile = 'aset/' . time() . '_' . $this->foto->getClientOriginalName();
            $this->foto->storeAs('aset', time() . '_' . $this->foto->getClientOriginalName(), 'public');
        }

        // ✅ Update aset ke database
        $aset->update([
            'kodeAset' => $this->kodeAset,
            'namaAset' => $this->namaAset,
            'kategori_id' => $this->kategori,
            'jumlah' => $this->jumlah,
            'unit_tersedia' => $this->unit_tersedia,
            'ruangan' => $this->ruangan,
            'status' => $this->status,
            'deskripsi' => $this->deskripsi,
            'foto' => $namaFile,
        ]);

        // ✅ Reset form dan beri notifikasi
        $this->reset([
            'id',
            'kodeAset',
            'namaAset',
            'kategori',
            'jumlah',
            'unit_tersedia',
            'ruangan',
            'status',
            'deskripsi',
            'foto',
            'foto_lama'
        ]);

        session()->flash('success', 'Data berhasil diperbarui!');
        return redirect()->route('aset');
    }


    public function confirmDelete($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        $aset = Aset::findOrFail($this->id);

        if ($aset) {
            // Hapus foto jika ada
            if ($aset->foto && Storage::disk('public')->exists($aset->foto)) {
                Storage::disk('public')->delete($aset->foto);
            }

            $aset->delete();
            session()->flash('success', 'Data aset berhasil dihapus!');
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        $this->resetExcept('kategoriList');
    }

    // Method untuk reset form
    public function resetForm()
    {
        $this->reset(['id', 'kodeAset', 'namaAset', 'kategori', 'jumlah', 'unit_tersedia', 'ruangan', 'status', 'deskripsi', 'foto', 'foto_lama']);
    }

    // Method untuk menghapus foto saat update (opsional)
    public function removeFoto()
    {
        $this->foto = null;
        $this->foto_lama = null;
    }
}