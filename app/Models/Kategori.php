<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'nama', 'deskripsi'];
    protected $table = "kategoris";
    protected $primaryKey = 'id';

    public function aset(){
        return $this->hasMany(Aset::class);
    }
}
