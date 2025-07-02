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
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.7/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Scan Image -->
    <script>
        function scanQrFromImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function () {
                const img = new Image();
                img.src = reader.result;

                img.onload = function () {
                    const canvas = document.createElement("canvas");
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const context = canvas.getContext("2d");
                    context.drawImage(img, 0, 0, img.width, img.height);

                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                    if (qrCode) {
                        const kode = qrCode.data;
                        console.log("Hasil scan dari gambar:", kode);
                        // Jika QR berisi id langsung redirect
                        // window.location.href = "/pelacakan/" + kode;

                        // Jika QR berisi kodeAset, redirect lewat route pelacakan/kode
                        window.location.href = "/detail/" + encodeURIComponent(kode);
                    } else {
                        alert("QR Code tidak terbaca. Pastikan gambarnya jelas.");
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    </script>

    <!-- Scan kamera -->
    <script>
        let html5QrCode;

        function startScanner() {
            const qrRegion = document.getElementById("reader");
            html5QrCode = new Html5Qrcode("reader");

            const qrConfig = { fps: 10, qrbox: 250 };

            html5QrCode.start(
                { facingMode: "environment" }, // kamera belakang
                qrConfig,
                (decodedText, decodedResult) => {
                    document.getElementById("scan-result").innerText = "Kode Aset: " + decodedText;

                    // Contoh redirect ke halaman detail
                    window.location.href = "/detail/" + decodedText;

                    stopScanner(); // matikan scanner setelah dapat
                },
                (errorMessage) => {
                    // console.log("Scan error: ", errorMessage);
                }
            ).catch((err) => {
                console.error("Gagal memulai kamera: ", err);
                alert("Gagal mengakses kamera");
            });
        }

        function stopScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                }).catch((err) => {
                    console.error("Gagal menghentikan kamera: ", err);
                });
            }
        }
    </script>

    <!-- Modal QR -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Livewire.on('show-qr-modal', () => {
                $('#qrModal').modal('show');
            });
        });
    </script>

    <!-- Script untuk download QR sebagai JPG -->
    <script>
        function downloadQrAsImage() {
            const qrContainer = document.getElementById('qr-content');
            const svg = qrContainer.querySelector('svg');

            if (!svg) {
                alert("SVG QR Code tidak ditemukan.");
                return;
            }

            const svgData = new XMLSerializer().serializeToString(svg);
            const svgBlob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });
            const url = URL.createObjectURL(svgBlob);

            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);

                const jpgData = canvas.toDataURL("image/jpeg");
                const a = document.createElement("a");
                a.href = jpgData;
                a.download = "qr-code.jpg";
                a.click();

                URL.revokeObjectURL(url);
            };
            img.src = url;
        }
    </script>

    <script>
        function downloadQrAsImage() {
            const qrElement = document.getElementById('qr-content');

            html2canvas(qrElement).then(canvas => {
                const link = document.createElement('a');
                link.href = canvas.toDataURL("image/jpeg");
                link.download = 'qr-kode-aset.jpg';
                link.click();
            }).catch(error => {
                alert("Gagal mengunduh gambar: " + error);
            });
        }
    </script>

    <!-- Toggle large -->
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

    <!-- Toggle Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileToggle = document.querySelector('.mobile-toggle');
            const sidebar = document.querySelector('.sidebar');

            mobileToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });
        });
    </script>

</body>

</html>