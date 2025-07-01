<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Laporan Peminjaman & Pengembalian</h2>
        </div>
        <div class="card-body">
            @if ($tanggalError)
                <div class="alert alert-danger mt-2 col-md-6">
                    {{ $tanggalError }}
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="tanggalMulai">Dari Tanggal</label>
                    <input type="date" id="tanggalMulai" wire:model="tanggalMulai" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="tanggalSelesai">Sampai Tanggal</label>
                    <input type="date" id="tanggalSelesai" wire:model="tanggalSelesai" class="form-control">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button wire:click="cariData" class="btn btn-primary mr-2">Cari</button>
                    <button wire:click="exportPdf" class="btn btn-danger" @if (!$tanggalMulai || !$tanggalSelesai || empty($filteredData)) disabled @endif>Export PDF</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table mt-3 text-center">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama User</th>
                            <th>Nama Aset</th>
                            <th>Jumlah Dipinjam</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($filteredData) && count($filteredData) > 0)
                            @foreach ($filteredData as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->user->nama ?? 'User Dihapus' }}</td>
                                    <td>{{ $item->aset->namaAset ?? 'Aset Dihapus' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                                    <td>
                                        @php
                                            $status = $item->status;

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
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Silakan pilih tanggal dan klik tombol "Cari" untuk menampilkan data.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>