<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "peminjamen";
    protected $primaryKey = "id"; 
    protected $fillable = ['aset_id', 'user_id', 'tgl_pinjam', 'tgl_kembali', 'status', 'jumlah'];

    // Defining the possible values for the 'status' field using Enum
    const STATUS_PENDING = 'pending';
    const STATUS_DIPINJAM = 'dipinjam';
    const STATUS_KEMBALI = 'kembali';

    const STATUS_DITOLAK = 'ditolak';

    // Accessor to get a human-readable status
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Aset
    public function aset(): BelongsTo
    {
        return $this->belongsTo(Aset::class);
    }

    // Validasi status
    public static function validateStatus($status)
    {
        $validStatuses = [self::STATUS_PENDING, self::STATUS_DIPINJAM, self::STATUS_KEMBALI, self::STATUS_DITOLAK];
        return in_array($status, $validStatuses);
    }
}
