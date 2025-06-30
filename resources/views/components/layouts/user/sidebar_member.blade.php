<nav class="navbar navbar-expand-lg fixed-top" style="background-color: white">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home_member') }}" style="font-weight: bold; font-size: 24px">
            <img src="{{ asset('image/logo.png') }}" alt="" style="width: 40px; margin-right: 10px" />PASTI
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto navlist">
                @auth
                    @if (auth()->check())
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('home_member') ? 'active' : '' }}"
                                href="{{ route('home_member') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('pelacakan') ? 'active' : '' }}"
                                href="{{ route('pelacakan') }}">Aset Kami</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="cart-icon">
                                <i class="bi bi-person-circle"></i>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ url()->current() == route('registrasi') ? 'active' : '' }}"
                                href="{{ route('registrasi') }}">Registrasi</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ url()->current() == route('login') ? 'active' : '' }}"
                            href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ url()->current() == route('registrasi') ? 'active' : '' }}"
                            href="{{ route('registrasi') }}">Registrasi</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>