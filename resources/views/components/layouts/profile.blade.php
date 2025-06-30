<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Profil' }} - PASTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @livewireStyles

    <style>
        body {
            background-color: #f9fafb;
        }

        .sidebar {
            height: 100vh;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                height: auto;
            }
        }

        .btn-back {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #007bff;
            color: white !important;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar py-4">
                <!-- Header dengan ikon kembali -->
                <div class="d-flex align-items-center px-3">
                    <a href="{{ auth()->user()->jenis === 'pengguna' ? route('home_member') : route('home') }}"
                        class="btn-back d-flex align-items-center justify-content-center mr-3">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <h5 class="mb-0 text-primary font-weight-bold">Akun Saya</h5>
                </div>
                <hr>
                <p class="text-center text-muted"><b>Hai, </b>{{ auth()->user()->nama }}</p>
                <p class="text-center badge badge-secondary">Role : {{ auth()->user()->jenis }}</p>

                <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }} mb-3">
                    <i class="fas fa-user"></i> Profil
                </a>
                @auth
                    @if (Auth::user()->jenis === 'pengguna')
                        <a href="{{ route('peminjaman') }}" class="{{ request()->routeIs('peminjaman') ? 'active' : '' }} mb-3">
                            <i class="fas fa-file"></i> Peminjaman
                        </a>
                        <a href="{{ route('kembali') }}" class="{{ request()->routeIs('kembali') ? 'active' : '' }} mb-3">
                            <i class="fas fa-calendar"></i> Pengembalian
                        </a>
                    @endif
                @endauth
                @livewire('logout-component')
            </div>


            <!-- Main Content -->
            <main class="col-md-9 py-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- JS & Livewire -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @livewireScripts
</body>

</html>