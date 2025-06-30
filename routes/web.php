<?php

use App\Livewire\AsetComponent;
use App\Livewire\DetailComponent;
use App\Livewire\HomeComponent;
use App\Livewire\HomeMemberComponent;
use App\Livewire\KategoriComponent;
use App\Livewire\KembaliComponent;
use App\Livewire\LaporanPeminjaman;
use App\Livewire\LaporanPengembalian;
use App\Livewire\LaporanPengguna;
use App\Livewire\LoginComponent;
use App\Livewire\LogoutComponent;
use App\Livewire\MemberComponent;
use App\Livewire\PelacakanComponent;
use App\Livewire\PeminjamanComponent;
use App\Livewire\ProfileComponent;
use App\Livewire\RegistrasiComponent;
use App\Livewire\UserComponent;
use Illuminate\Support\Facades\Route;

// Halaman khusus ADMIN (memerlukan login + role admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', HomeComponent::class)->name('home');
    Route::get('/user', UserComponent::class)->name('user');
    Route::get('/member', MemberComponent::class)->name('member');
    Route::get('/kategori', KategoriComponent::class)->name('kategori');
    Route::get('/aset', AsetComponent::class)->name('aset');
    Route::get('/laporanPeminjaman', LaporanPeminjaman::class)->name('laporanPeminjaman');
    Route::get('/laporanPengembalian', LaporanPengembalian::class)->name('laporanPengembalian');
    Route::get('/laporanPengguna', LaporanPengguna::class)->name('laporanPengguna');
});

// Halaman untuk semua user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', ProfileComponent::class)->name('profile');
    Route::get('/peminjaman', PeminjamanComponent::class)->name('peminjaman');
    Route::get('/pengembalian', KembaliComponent::class)->name('kembali');
    Route::get('/detail/{id}', DetailComponent::class)->name('detail');
    Route::post('/logout', LogoutComponent::class)->name('logout');
});

// Halaman publik (tidak perlu login)
Route::get('/', HomeMemberComponent::class)->name('home_member');
Route::get('/pencarian', PelacakanComponent::class)->name('pelacakan');

// Halaman autentikasi (untuk user yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', LoginComponent::class)->name('login');
    Route::get('/registrasi', RegistrasiComponent::class)->name('registrasi');
});