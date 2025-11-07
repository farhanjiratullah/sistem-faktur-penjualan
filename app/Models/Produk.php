<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'price',
        'satuan',
        'jenis',
        'stok',
    ];

    public $timestamps = false;

    public function detailFakturs(): HasMany
    {
        return $this->hasMany(DetailFaktur::class, 'id_produk', 'id_produk');
    }
}
