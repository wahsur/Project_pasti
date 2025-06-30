<div class="container">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row login-card mx-auto">
        <div class="col-md-6 login-image text-center">
            <img src="{{ asset('image/key.png') }}" alt="Login Illustration" class="img-fluid">
        </div>
        <div class="col-md-6 login-form">
            <h4 class="fw-bold mb-1 text-center">SELAMAT DATANG PENGGUNA</h4>
            <p class="text-muted mb-4 text-center">Silahkan Melakukan Registrasi</p>

            <form wire:submit.prevent="register">
                <div class="mb-1">
                    <label for="nama" class="form-label">Username</label>
                    <input type="text" class="form-control" id="nama" placeholder="Enter your username"
                        wire:model="nama">
                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-1">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email"
                        wire:model="email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-1">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="telepon" placeholder="Enter your number"
                        wire:model="telepon">
                    @error('telepon') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" wire:model="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100">Daftar</button>

                <p class="text-center mt-3 text-small">
                    Have an account? <a href="{{ route('login') }}" class="text-danger">Login Here!</a>
                </p>
            </form>
        </div>
    </div>
</div>