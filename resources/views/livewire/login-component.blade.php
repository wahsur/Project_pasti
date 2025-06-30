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
            <h4 class="fw-bold mb-1 text-center">SELAMAT DATANG KEMBALI</h4>
            <p class="text-muted mb-4 text-center">Silakan Login kembali</p>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" wire:model="email" class="form-control" id="email"
                        placeholder="Enter your email">
                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" wire:model="password" class="form-control" id="password"
                        placeholder="********">
                    @error('password')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none text-small">Forgot password</a>
                </div>
                <button type="button" wire:click="proses" class="btn btn-login w-100">Login</button>
                <p class="text-center mt-3 text-small">Don't have an account? <a href="{{ route('registrasi') }}"
                        class="text-danger">Sign up
                        for free!</a></p>
            </form>
        </div>
    </div>
</div>