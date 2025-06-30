<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Laporan Pengembalian</h2>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="d-flex justify-content-between mb-3">
                <!-- Tombol Tambah di kanan -->
                <a href="#" class="btn btn-primary ml-2" data-toggle="modal" data-target="#">Print</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Peminjamn_id</th>
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
                                <td>{{ $data->peminjaman_id }}</td>
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
</div>