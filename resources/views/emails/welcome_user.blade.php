@component('mail::message')

<img src="https://i.imgur.com/9zXYXtw.png" alt="PASTI Logo" width="150" style="margin-bottom: 20px;">

# Terima Kasih Telah Mendaftar di PASTI

Halo {{ $user->nama }},

Terima kasih telah mendaftar akun di aplikasi PASTI.

Berikut data diri Anda yang tercatat:

- Nama: {{ $user->nama }}
- Email: {{ $user->email }}
- Nomor Telepon: {{ $user->telepon }}

Jika ada kesalahan data, silakan hubungi admin.

Terima kasih,<br>
Tim PASTI

@endcomponent