<div class="container-fluid px-3">
    <div class="row justify-content-center mb-4 mt-3">
        <div class="col-lg-6 col-md-8 col-sm-10 col-12 d-flex">
            <input type="text" wire:model.live="cari" class="form-control mr-2" placeholder="Cari...">
            <button class="btn btn-success" data-toggle="modal" data-target="#scanModal" onclick="startScanner()">
                Scan QR Code
            </button>
        </div>
    </div>

    <div class="row">
        @forelse ($asets as $aset)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $aset->foto) }}" class="card-img-top img-fluid mx-auto d-block"
                        style="max-height: 200px; width: auto;" alt="{{ $aset->namaAset }}">
                    <div class="card-body">
                        <h5 class="card-title text-center"><b>Nama Aset :</b> {{ $aset->namaAset }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted text-center"><b>Kategori :</b> {{ $aset->kategori->nama }}
                        </h6>
                        <p class="card-text"><b>Kode Aset :</b> {{ $aset->kodeAset }}</p>
                        <p class="card-text"><b>Deskripsi :</b> {{ \Illuminate\Support\Str::limit($aset->deskripsi, 100) }}
                        </p>
                        <div class="d-grid">
                            <a href="{{ route('detail', ['id' => $aset->id]) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada aset ditemukan.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Scan QR Code -->
    <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Scan QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reader" style="width:100%"></div>
                    <p id="scan-result" class="mt-3 font-weight-bold"></p>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <label for="qrImage">Import Gambar QR Code:</label>
                        <input type="file" id="qrImage" accept="image/*" class="form-control-file"
                            onchange="scanQrFromImage(event)">
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="stopScanner()">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>