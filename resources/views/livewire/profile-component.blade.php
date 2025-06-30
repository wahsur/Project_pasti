<div class="container mt-4">
    <h4>{{ $title ?? 'Profil Saya' }}</h4>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control" wire:model="nama">
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" wire:model="email">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" class="form-control" wire:model="telepon">
            @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea class="form-control" wire:model="alamat"></textarea>
            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <hr>

    @auth
        @if (Auth::user()->jenis === 'admin')
            <h5>Ubah Password</h5>
            <form wire:submit.prevent="updatePassword">
                <div class="mb-3">
                    <label>Password Baru</label>
                    <input type="password" class="form-control" wire:model="password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-warning">Ubah Password</button>

                @if (session()->has('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        @endif
    @endauth
</div>