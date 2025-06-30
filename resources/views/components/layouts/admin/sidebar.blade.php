<nav id="sidebar" class="col-md-2 bg-dark sidebar shadow">
    <div class="sidebar-sticky">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('image/logo.png') }}" alt="PASTI Logo" width="100">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('home') ? 'active' : '' }}"
                    href="{{ route('home') }}">
                    <span data-feather="home"></span> Dashboard
                </a>
            </li>

            <p class="text-white text-uppercase fw-semibold mx-3 my-2 small border-bottom">Manajemen User</p>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('member') ? 'active' : '' }}"
                    href="{{ route('member') }}">
                    <span data-feather="users"></span> Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('user') ? 'active' : '' }}"
                    href="{{ route('user') }}">
                    <span data-feather="user"></span> Staff
                </a>
            </li>

            <p class="text-white text-uppercase fw-semibold mx-3 my-2 small border-bottom">Manajemen asset</p>\
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('kategori') ? 'active' : '' }}"
                    href="{{ route('kategori') }}">
                    <span data-feather="tag"></span> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('aset') ? 'active' : '' }}" href="{{ route('aset') }}">
                    <span data-feather="box"></span> Aset
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('peminjaman') ? 'active' : '' }}"
                    href="{{ route('peminjaman') }}">
                    <span data-feather="file"></span> Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('pengembalian') ? 'active' : '' }}"
                    href="{{ route('kembali') }}">
                    <span data-feather="check-circle"></span> Pengembalian
                </a>
            </li>

            <p class="text-white text-uppercase fw-semibold mx-3 my-2 small border-bottom">Melacak</p>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('pelacakan') ? 'active' : '' }}"
                    href="{{ route('pelacakan') }}">
                    <span data-feather="tag"></span> Pelacakan Aset
                </a>
            </li>

            <p class="text-white text-uppercase fw-semibold mx-3 my-2 small border-bottom">Laporan</p>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('laporanPeminjaman') ? 'active' : '' }}"
                    href="{{ route('laporanPeminjaman') }}">
                    <span data-feather="file-text"></span> Laporan Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('laporanPengembalian') ? 'active' : '' }}"
                    href="{{ route('laporanPengembalian') }}">
                    <span data-feather="file-text"></span> Laporan Pengembalian
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('laporanPengguna') ? 'active' : '' }}"
                    href="{{ route('laporanPengguna') }}">
                    <span data-feather="file-text"></span> Laporan Pengguna
                </a>
            </li>
        </ul>
    </div>
</nav>