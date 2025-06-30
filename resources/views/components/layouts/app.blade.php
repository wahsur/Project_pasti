<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>
    <link rel="icon" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('template/admin-dashboard.css')}}">
    <link rel="stylesheet" href="{{ asset('template/style.css') }}">
    <style>
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 250px;
                z-index: 1050;
                /* lebih tinggi dari konten utama */
                background-color: #343a40;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                position: relative;
                z-index: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('components.layouts.admin.sidebar')

    <!-- Toggle Button Desktop (hanya tampil di layar besar) -->
    <button class="menu-toggle d-none d-md-inline-block m-2">
        <i data-feather="chevron-right"></i>
    </button>

    <!-- Toggle Button Mobile (hanya tampil di layar kecil) -->
    <button class="btn btn-primary d-md-none mobile-toggle position-fixed m-2" style="z-index: 1050;">
        ☰
    </button>

    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main role="main" class="col main-content">
                <!-- Navigasi -->
                @include('components.layouts.admin.navigasi')

                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        feather.replace();

        const toggleBtn = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('full-width');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileToggle = document.querySelector('.mobile-toggle');
            const sidebar = document.querySelector('.sidebar');

            mobileToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            feather.replace();

            const laporanLink = document.querySelector('[href="#laporanSubmenu"]');
            const laporanCollapse = document.getElementById('laporanSubmenu');
            const chevronIcon = laporanLink?.querySelector('.chevron-icon');

            if (laporanCollapse && chevronIcon) {
                laporanCollapse.addEventListener('show.bs.collapse', function () {
                    chevronIcon.classList.add('rotate');
                });

                laporanCollapse.addEventListener('hide.bs.collapse', function () {
                    chevronIcon.classList.remove('rotate');
                });
            }
        });
    </script>
</body>

</html>