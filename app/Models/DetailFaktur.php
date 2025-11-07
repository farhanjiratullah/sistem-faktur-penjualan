<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailFaktur extends Model
{
    use HasFactory;

    protected $table = 'detail_faktur';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'id_produk',
        'no_faktur',
        'qty',
        'price',
    ];

    public $timestamps = false;

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function faktur(): BelongsTo
    {
        return $this->belongsTo(Faktur::class, 'no_faktur', 'no_faktur');
    }

    public function getSubtotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
