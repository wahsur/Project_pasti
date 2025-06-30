<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Kelola Peminjaman</h2>
        </div>
        <div class="card-body">
            {{-- ✅ PERBAIKAN: Tambahkan tampilan pesan success --}}
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            {{-- ✅ PERBAIKAN: Tambahkan tampilan pesan error --}}
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="d-flex justify-content-between mb-3">
                <!-- Form Cari di kiri -->
                <input type="text" wire:model.live="cari" class="form-control w-50" placeholder="Cari..... ">

                <!-- Tombol Tambah di kanan -->
                <a href="#" class="btn btn-primary ml-2" data-toggle="modal"
                    data-target="#modalTambahPeminjaman">Tambah</a>
            </div>
            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Nama Aset</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            @auth
                                @if (Auth::user()->jenis === 'admin')
                                    <th>Aksi</th>
                                @endif
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $pinjam)
                            <tr>
                                <td>{{ $peminjaman->firstItem() + $index }}</td>
                                <td>{{ $pinjam->user->nama ?? 'User sudah tidak ada' }}</td>
                                <td>{{ $pinjam->aset->namaAset ?? 'Aset dihapus' }}</td>
                                <td>{{ $pinjam->tgl_pinjam }}</td>
                                <td>{{ $pinjam->tgl_kembali }}</td>
                                <td>{{ $pinjam->jumlah }}</td>
                                <td>
                                    @php
                                        $status = $pinjam->status;

                                        $badgeClass = match ($status) {
                                            'pending' => 'badge-warning',
                                            'dipinjam' => 'badge-info',
                                            'ditolak' => 'badge-danger',
                                            'kembali' => 'badge-success',
                                            default => 'badge-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    @auth
                                        @if (Auth::user()->jenis === 'admin')
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#modalEditPeminjaman" wire:click="edit({{ $pinjam->id }})">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus"
                                                wire:click="confirmDelete({{ $pinjam->id }})">
                                                Hapus
                                            </button>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                {{-- Pagination --}}
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div wire:ignore.self class="modal fade" id="modalTambahPeminjaman" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Peminjaman</h5>
                        <button type="button" class="close" data-dismiss="modal" wire:click="resetForm">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Aset</label>
                            <select class="form-control" wire:model="aset_id">
                                <option value="">-- Pilih Aset --</option>
                                @foreach ($aset as $data)
                                    <option value="{{ $data->id }}">{{ $data->namaAset }} (Tersisa:
                                        {{ $data->unit_tersedia }})
                                    </option>
                                @endforeach
                            </select>
                            @error('aset_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Jumlah Pinjam</label>
                            <input type="number" wire:model="jumlah" class="form-control" min="1">
                            @error('jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Pinjam</label>
                            <input type="date" class="form-control" wire:model="tgl_pinjam">
                            @error('tgl_pinjam') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Kembali</label>
                            <input type="date" class="form-control" wire:model="tgl_kembali">
                            @error('tgl_kembali') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="store" class="btn btn-primary"
                            data-dismiss="modal">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            wire:click="resetForm">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Update --}}
    <div wire:ignore.self class="modal fade" id="modalEditPeminjaman" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Peminjaman</h5>
                        <button type="button" class="close" data-dismiss="modal" wire:click="resetForm">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Aset</label>
                            <select class="form-control" wire:model="aset_id">
                                <option value="">-- Pilih Aset --</option>
                                @foreach ($aset as $data)
                                    <option value="{{ $data->id }}">{{ $data->namaAset }} (Tersisa:
                                        {{ $data->unit_tersedia }})
                                    </option>
                                @endforeach
                            </select>
                            @error('aset_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Jumlah Pinjam</label>
                            <input type="number" wire:model="jumlah" class="form-control" min="1">
                            @error('jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Pinjam</label>
                            <input type="date" class="form-control" wire:model="tgl_pinjam">
                            @error('tgl_pinjam') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Kembali</label>
                            <input type="date" class="form-control" wire:model="tgl_kembali">
                            @error('tgl_kembali') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" wire:model="status">
                                <option value="pending">Pending</option>
                                <option value="dipinjam">Dipinjam</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="update" class="btn btn-primary"
                            data-dismiss="modal">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            wire:click="resetForm">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div wire:ignore.self class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
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
</div>