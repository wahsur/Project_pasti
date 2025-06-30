<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Laporan Peminjaman</h2>
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
                <!-- Tombol Tambah di kanan -->
                <a href="#" class="btn btn-primary ml-2" data-toggle="modal"
                    data-target="#">Print</a>
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $pinjam)
                            <tr>
                                <td>{{ $peminjaman->firstItem() + $index }}</td>
                                <td>{{ $pinjam->user->nama }}</td>
                                <td>{{ $pinjam->aset->namaAset }}</td>
                                <td>{{ $pinjam->tgl_pinjam }}</td>
                                <td>{{ $pinjam->tgl_kembali }}</td>
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
</div>