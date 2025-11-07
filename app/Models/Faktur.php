<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faktur extends Model
{
    use HasFactory;

    protected $table = 'faktur';

    protected $primaryKey = 'no_faktur';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_faktur',
        'tgl_faktur',
        'due_date',
        'metode_bayar',
        'ppn',
        'dp',
        'grand_total',
        'user',
        'id_customer',
        'id_perusahaan',
    ];

    protected $casts = [
        'tgl_faktur' => 'datetime',
        'due_date' => 'datetime',
    ];

    public $timestamps = false;

    public static function generateNoFaktur()
    {
        $prefix = 'PJ' . date('ymd');
        $lastFaktur = self::where('no_faktur', 'like', $prefix . '%')->orderBy('no_faktur', 'desc')->first();

        if ($lastFaktur) {
            $lastNumber = intval(substr($lastFaktur->no_faktur, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }


    public function detailFaktur(): HasMany
    {
        return $this->hasMany(DetailFaktur::class, 'no_faktur', 'no_faktur');
    }
}
