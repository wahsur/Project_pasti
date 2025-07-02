<div id="dashboard" class="mb-4">
    <section class="card shadow p-3 mb-4">
        <h2>Overview</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">
                        <a class="text-white" href="{{ route('member') }}"><span data-feather="users"
                                class="mr-2"></span> Pengguna </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total: {{ $member }}</h5>
                        <p class="card-text">Pengguna Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">
                        <a class="text-white" href="{{ route('aset') }}"><span data-feather="box" class="mr-2"></span>
                            Aset</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total: {{ $aset }}</h5>
                        <p class="card-text">Aset Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">
                        <a class="text-white" href="{{ route('peminjaman') }}"><span data-feather="file-text"
                                class="mr-2"></span>
                            Peminjaman</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Aktif: {{ $pinjam }}</h5>
                        <p class="card-text">Aset di pinjam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">
                        <a class="text-white" href="{{ route('kembali') }}"><span data-feather="clock"
                                class="mr-2"></span>
                            Pengembalian</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Pengembalian: {{ $kembali }}</h5>
                        <p class="card-text">Pengembalian Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <!-- Kolom Kiri: Peminjaman Terbaru -->
        <div class="col-lg-8 mb-4 order-2 order-lg-1">
            <section class="card shadow p-3 h-100">
                <div class="card-header d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0">Peminjaman Terbaru</h4>
                    <a href="{{ route('peminjaman') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
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
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $pinjam->user->nama }}</td>
                                                                <td>{{ $pinjam->aset->namaAset ?? 'Aset Dihapus' }}</td>
                                                                <td>{{ $pinjam->tgl_pinjam }}</td>
                                                                <td>{{ $pinjam->tgl_kembali }}</td>
                                                                <td>
                                                                    <span class="badge 
                                                                                                    {{ $pinjam->status === 'pending' ? 'bg-warning text-dark' :
                                    ($pinjam->status === 'dipinjam' ? 'bg-info text-dark' : 'bg-success') }}">
                                                                        {{ ucfirst($pinjam->status) }}
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
                    </div>
                </div>
            </section>
        </div>

        <!-- Kolom Kanan: Peminjam Teratas -->
        <div class="col-lg-4 mb-4 order-1 order-lg-2">
            <section class="card shadow p-3 h-100">
                <div class="card-header mb-2">
                    <h5 class="mb-0">Peminjam Teratas</h5>
                </div>
                <div class="card-body">
                    @forelse ($topPeminjam as $user)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>{{ $user->nama }}</span>
                            <span class="badge bg-primary">{{ $user->jumlah_pinjam }}x</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">Belum ada peminjaman.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <!-- Chart -->
    <livewire:statistik-chart />
</div>