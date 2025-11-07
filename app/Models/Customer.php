<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'nama_customer',
        'perusahaan_cust',
        'alamat',
    ];

    public $timestamps = false;

    public function fakturs(): HasMany
    {
        return $this->hasMany(Faktur::class, 'id_customer', 'id_customer');
    }
}
