<div>
    <div class="card shadow mb-5">
        <div class="card-header">
            <h2>Kelola Pengembalian</h2>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <input type="text" wire:model="cari" class="form-control w-50" placeholder="Cari...">
            </div>

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
                        @forelse ($peminjaman as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->user->nama }}</td>
                                <td>{{ $data->aset->namaAset }}</td>
                                <td>{{ $data->tgl_pinjam }}</td>
                                <td>{{ $data->tgl_kembali }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>
                                    @php
                                        $status = $data->status;

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
                                            <a href="#" wire:click="pilih({{ $data->id }})" class="btn btn-outline-success btn-transparent btn-sm"
                                                data-toggle="modal" data-target="#pilih">Proses</a>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>

    <!-- History Pengembalian -->
    <div class="card shadow">
        <div class="card-header">
            <h2>History Pengembalian</h2>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <input type="text" wire:model="cari" class="form-control w-50" placeholder="Cari...">
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Aset Dipinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengembalian as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->peminjaman->user->nama }}</td>
                                <td>{{ $data->peminjaman->aset->namaAset ?? 'Aset Dihapus' }}</td>
                                <td>{{ $data->tgl_kembali }}</td>
                                <td>{{ $data->denda }}</td>
                                <td>
                                    @php
                                        $status = $data->peminjaman->status;

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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $pengembalian->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div wire:ignore.self class="modal fade" id="pilih" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Pengembalian</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Nama Aset
                            </div>
                            <div class="col-md-8">
                                : {{ $namaAset }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Nama User
                            </div>
                            <div class="col-md-8">
                                : {{ $user }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Tgl Kembali
                            </div>
                            <div class="col-md-8">
                                : {{ $tgl_kembali }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Tgl Hari ini
                            </div>
                            <div class="col-md-8">
                                : {{ date('Y-m-d') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Denda
                            </div>
                            <div class="col-md-8">
                                : @if ($this->status == true)
                                    Ya
                                @else
                                    Tidak
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Lama Terlambat
                            </div>
                            <div class="col-md-8">
                                : {{ $lama }} Hari
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Jumlah Denda
                            </div>
                            <div class="col-md-8">
                                : @if ($this->status == true)
                                    {{ $denda = $this->lama * 1000 }}
                                @else
                                    {{ $denda = 0 }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="store" class="btn btn-primary"
                            data-dismiss="modal">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>