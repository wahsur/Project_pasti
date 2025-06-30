<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "asets";
    protected $primarykey = "id";
    protected $fillable = ['id', 'kodeAset', 'namaAset','kategori_id','jumlah','unit_tersedia','ruangan','status','deskripsi','foto'];

    public function kategori(): BelongsTo{
        return $this->belongsTo(Kategori::class);
    }

}
