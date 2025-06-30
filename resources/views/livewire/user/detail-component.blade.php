<div>
    <div class="container py-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detail Aset: {{ $aset->namaAset }}</h4>
            </div>

            <div class="card-body row align-items-center">

                <div class="col-md-6 text-center mb-4 mb-md-0">
                    @if($aset->foto)
                        <img src="{{ asset('storage/' . $aset->foto) }}" class="img-fluid rounded shadow"
                            style="max-height: 400px;" alt="Gambar Aset">
                    @else
                        <p class="text-muted">Tidak ada gambar</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <p><strong>Kode Aset:</strong> {{ $aset->kodeAset }}</p>
                    <p><strong>Kategori:</strong> {{ $aset->kategori->nama ?? '-' }}</p>
                    <p><strong>Stok:</strong> {{ $aset->unit_tersedia}}</p>
                    <p><strong>Lokasi:</strong> {{ $aset->ruangan }}</p>
                    <p><strong>Status:</strong> {{ $aset->status }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <div class="bg-light p-3 rounded shadow-sm">
                        {!! nl2br(e($aset->deskripsi)) !!}
                    </div>
                </div>

            </div>

            <div class="card-footer text-end">
                <a href="{{ route('pelacakan') }}" class="btn btn-secondary">← Kembali</a>
                <button wire:click="openModal" class="btn btn-primary">
                    Pinjam Aset
                </button>
            </div>
        </div>

        {{-- Modal Form Pinjam --}}
        @if ($showModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Form Peminjaman</h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                        {{-- ✅ PERBAIKAN: Tambahkan tampilan pesan error --}}
                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Jumlah Pinjam</label>
                                <input type="number" wire:model="jumlah" class="form-control" min="1">
                                @error('jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Pinjam</label>
                                <input type="date" wire:model="tgl_pinjam" class="form-control">
                                @error('tgl_pinjam') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Kembali</label>
                                <input type="date" wire:model="tgl_kembali" class="form-control">
                                @error('tgl_kembali') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button class="btn btn-primary" wire:click="simpanPinjam">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>