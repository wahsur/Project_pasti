<div class="container">
    <div class="row">
        <!-- Pie Chart -->
        <div class="col-md-6 mb-3">
            <div class="card shadow p-3 h-100 d-flex">
                <h5 class="card-title text-center">Distribusi Aset per Kategori</h5>
                <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                    <canvas id="pieChart" class="mx-auto d-block"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-6 mb-3">
            <div class="card shadow p-3 h-100 d-flex">
                <h5 class="card-title text-center">Peminjaman Per Bulan</h5>
                <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                    <canvas id="barChart" class="mx-auto d-block"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: @json($kategoriLabels),
                datasets: [{
                    data: @json($kategoriData),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            }
        });

        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: @json($bulanLabels),
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($peminjamanData),
                    backgroundColor: '#36A2EB'
                }]
            }
        });
    });
</script>