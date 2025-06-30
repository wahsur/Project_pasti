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
</head>

<body>
    <!-- Sidebar -->
    @include('components.layouts.admin.sidebar')

    <!-- Toggle Button -->
    <button class="menu-toggle">
        <i data-feather="chevron-right"></i>
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
        document.addEventListener("DOMContentLoaded", function () {
            feather.replace();

            const laporanLink = document.querySelector('[href="#laporanSubmenu"]');
            const laporanCollapse = document.getElementById('laporanSubmenu');
            const chevronIcon = laporanLink.querySelector('.chevron-icon');

            laporanCollapse.addEventListener('show.bs.collapse', function () {
                chevronIcon.classList.add('rotate');
            });

            laporanCollapse.addEventListener('hide.bs.collapse', function () {
                chevronIcon.classList.remove('rotate');
            });
        });
    </script>
</body>

</html>