<div>
    <div class="card shadow">
        <div class="card-header">
            <h2>Laporan Pengguna</h2>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="d-flex justify-content-between mb-3">
                <!-- Tombol Tambah di kanan -->
                <a href="#" class="btn btn-primary ml-2" data-toggle="modal" data-target="#">Print</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->telepon }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>{{ $data->jenis }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $member->links() }}
            </div>
        </div>
    </div>
</div>