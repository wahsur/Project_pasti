<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'PASTI')</title>
    <link rel="icon" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('template/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/style1.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/style2.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet" />
    <style>
        .input {
            background: linear-gradient(90deg, #00008b, #add8e6);
            color: white;
        }

        .input h1 {
            font-weight: bold;
        }

        .input .input-group input {
            border: none;
            border-radius: 0;
        }

        .input .input-group .btn {
            background-color: white;
            color: #00008b;
        }
    </style>
</head>

<body>
    @include('components.layouts.user.sidebar_member')

    <main>
        {{ $slot }}
    </main>
    @include('components.layouts.user.footer')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>