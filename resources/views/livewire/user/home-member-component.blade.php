<div>
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Total -->
    <div class="container py-5">
        <div class="row align-items-center">
            <!-- Bagian Gambar: Order 1 di mobile, Order 2 di desktop -->
            <div class="col-lg-6 text-center text-lg-end order-1 order-lg-2 mb-4 mb-lg-0">
                <div class="position-relative d-inline-block">
                    <img src="{{ asset('image/logo.png') }}" alt="logo" class="img-fluid position-relative z-1"
                        style="max-width: 300px;">
                </div>
            </div>

            <!-- Bagian Teks: Order 2 di mobile, Order 1 di desktop -->
            <div class="col-lg-6 text-center text-lg-start order-2 order-lg-1">
                <h1 class="h5 fw-semibold text-primary">
                    Selamat Datang👋,
                    <span class="d-block fw-bold text-dark display-5">We are PASTI</span>
                </h1>
                <h2 class="fw-medium text-secondary fs-4 mb-3">Peminjaman Aset Teknologi Informasi</h2>
                <p class="text-muted mb-4 text-justify">
                    Kebutuhan Aset anda dalam menunjang kegiatan anda di dalam teknologi dapat anda pinjam dengan mudah
                    disini,
                    Silahkan lihat kategori dan aset yang kami miliki, semoga dapat membantu kebutuhan anda.
                    Salam Hangat Pastiers✌️
                </p>
                @auth
                    @if (auth()->check())
                        <a href="#kategori" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            Get Started
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            Get Started
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>



    <!-- Kategori -->
    <section id="kategori" class="py-5 bg-light">
        <div class="container">
            <!-- Judul -->
            <div class="text-center mb-5">
                <h3 class="text-primary fw-semibold mb-2">Kategori</h3>
                <h2 class="fw-bold text-dark display-5 mb-3">yang kami miliki</h2>
                <p class="text-secondary fs-5">
                    Silahkan lihat beberapa kategori yang kami miliki disini
                </p>
            </div>

            <!-- Daftar Kategori -->
            <div class="row justify-content-center">
                @if (isset($kategoris) && count($kategoris) > 0)
                    @foreach ($kategoris as $kategori)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                            <a href="#" class="text-decoration-none text-center d-block">
                                <div class="p-3 border rounded shadow-sm h-100 bg-info">
                                    <p class="mb-0 text-dark fw-medium">{{ $kategori->nama }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="text-muted">Kategori tidak ada</p>
                    </div>
                @endif
            </div>
        </div>
    </section>


    <!-- Aset Terbaru -->
    <div class="container py-5">
        <!-- Judul -->
        <div class="text-center mb-5">
            <h3 class="text-primary fw-semibold mb-2">Aset Terbaru</h3>
            <p class="text-secondary fs-5">
                Silahkan lihat beberapa aset terbaru kami
            </p>
        </div>
        <div class="row align-items-center">
            <!-- Kiri: 6 Gambar Aset Terbaru Ukuran Kecil -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="row g-2">
                    @foreach ($asets->take(6) as $aset)
                        <div class="col-6">
                            <div class="border rounded p-1 bg-light text-center h-100">
                                @if ($aset->foto)
                                    <img src="{{ asset('storage/' . $aset->foto) }}" class="img-fluid rounded mb-1"
                                        style="max-height: 100px; object-fit: cover;" alt="{{ $aset->namaAset }}">
                                @else
                                    <img src="{{ asset('image/default-product.png') }}" class="img-fluid rounded mb-1"
                                        style="max-height: 80px; object-fit: cover;" alt="Default Image">
                                    <small class="d-block text-muted">Gambar tidak tersedia</small>
                                @endif
                                <p class="small mb-0 text-dark">{{ $aset->namaAset }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Kanan: Teks Sambutan -->
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="h6 fw-semibold text-primary">
                    Lihat lah Aset kami disebalah kiri 👈,
                    <span class="d-block fw-bold text-dark fs-2">We are PASTI</span>
                </h1>
                <h2 class="fw-medium text-secondary fs-5 mb-3">Peminjaman Aset Teknologi Informasi</h2>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">
                    Apakah setelah melihat beberapa koleksi terbaru kami anda menjadi yakin untuk melakukan peminjaman
                    ?,
                    Ayo ketahui lebih banyak tentang aset yang kami miliki.👋
                </p>
                @auth
                    @if (auth()->check())
                        <a href="{{ route('pelacakan') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            Aset Kami
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            Aset Kami
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        Aset Kami
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>