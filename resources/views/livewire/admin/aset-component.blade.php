<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Kelola Aset</h2>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form cari dan tombol tambah --}}
            <div class="d-flex justify-content-between mb-3">
                <!-- Form Cari di kiri -->
                <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari..... ">

                <!-- Tombol Tambah di kanan -->
                <a href="#" class="btn btn-primary ml-2" data-toggle="modal" data-target="#tambahAset">Tambah</a>
            </div>

            {{-- Tabel responsif --}}
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Unit Tersedia</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="min-width: 150px;">Deskripsi</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aset as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->kodeAset }}</td>
                                <td>{{ $data->namaAset }}</td>
                                <td>{{ $data->kategori->nama ?? 'Kategori Dihapus' }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>{{ $data->unit_tersedia }}</td>
                                <td>{{ $data->ruangan }}</td>
                                <td>{{ $data->status }}</td>
                                <td class="text-wrap" style="max-width: 200px;">{{ $data->deskripsi }}</td>
                                <td>
                                    @if ($data->foto)
                                        <img src="{{ asset('storage/' . $data->foto) }}" width="70" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>
                                    @auth
                                        @if (Auth::user()->jenis === 'admin')
                                            <a href="#" class="btn btn-outline-warning btn-transparent btn-sm d-inline-block me-1 mb-2" wire:click="edit({{ $data->id }})"
                                                data-toggle="modal" data-target="#editPage">Ubah</a>
                                            <a href="#" class="btn btn-sm btn-outline-danger btn-transaprent d-inline-block mb-2" wire:click="confirmDelete({{ $data->id }})"
                                                data-toggle="modal" data-target="#deletePage">Hapus</a>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{ $aset->links() }}
            </div>
        </div>
    </div>


    <!-- Ubah -->
    <div wire:ignore.self class="modal fade" id="editPage" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aset</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- ✅ Tambahkan enctype -->
                    <form enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model="namaAset">
                            @error('namaAset') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select wire:model="kategori" class="form-control">
                                <option value="">--Pilih Kategori--</option>
                                @foreach ($kategoriList as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" wire:model="jumlah">
                            @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Unit Tersedia</label>
                            <input type="number" class="form-control" wire:model="unit_tersedia">
                            @error('unit_tersedia') <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Ruangan</label>
                            <input type="text" class="form-control" wire:model="ruangan">
                            @error('ruangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="status" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="aktif">Aktif</option>
                                <option value="rusak">Rusak</option>
                                <option value="maintenance">Perawatan</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" wire:model="deskripsi">
                            @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Foto (Opsional)</label>
                            <input type="file" class="form-control" wire:model.defer="foto" accept="image/*">
                            @error('foto') <small class="text-danger">{{ $message }}</small> @enderror

                            <div wire:loading wire:target="foto" class="text-info small mt-1">
                                Mengunggah gambar...
                            </div>
                        </div>

                        @if ($foto)
                            <div class="mt-2">
                                <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail" width="100">
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" wire:click="update">Simpan</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Konfirmasi Hapus -->
    <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    Apakah kamu yakin ingin menghapus pengguna ini?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" wire:click="delete" data-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah -->
    <div wire:ignore.self class="modal fade" id="tambahAset" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aset</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- ✅ Tambahkan enctype -->
                    <form enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model="namaAset">
                            @error('namaAset') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select wire:model="kategori" class="form-control">
                                <option value="">--Pilih Kategori--</option>
                                @foreach ($kategoriList as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" wire:model="jumlah">
                            @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Unit Tersedia</label>
                            <input type="number" class="form-control" wire:model="unit_tersedia">
                            @error('unit_tersedia') <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Ruangan</label>
                            <input type="text" class="form-control" wire:model="ruangan">
                            @error('ruangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="status" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="aktif">Aktif</option>
                                <option value="rusak">Rusak</option>
                                <option value="maintenance">Perawatan</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" wire:model="deskripsi">
                            @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Foto (Opsional)</label>
                            <input type="file" class="form-control" wire:model.defer="foto" accept="image/*">
                            @error('foto') <small class="text-danger">{{ $message }}</small> @enderror

                            <div wire:loading wire:target="foto" class="text-info small mt-1">
                                Mengunggah gambar...
                            </div>
                        </div>

                        @if ($foto)
                            <div class="mt-2">
                                <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail" width="100">
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" wire:click="store">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>