<div class="container-fluid px-3">
    <div class="row justify-content-center mb-4 mt-3">
        <div class="col-lg-6 col-md-8 col-sm-10 col-12 d-flex">
            <input type="text" wire:model.live="cari" class="form-control mr-2" placeholder="Cari...">
            <button class="btn btn-primary" data-toggle="modal" data-target="#">Scan</button>
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
</div>