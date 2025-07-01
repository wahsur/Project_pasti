<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Laporan Pengguna</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button wire:click="exportPdf" class="btn btn-danger">Export PDF</button>
            </div>
            <div class="table-responsive">
                <table class="table mt-3 text-center">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->nama}}</td>
                                <td>{{ $item->email}}</td>
                                <td>{{ $item->telepon}}</td>
                                <td>{{ $item->alamat}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>