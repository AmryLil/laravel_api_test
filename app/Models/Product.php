<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $primaryKey = 'kode_barang';
    protected $keyType    = 'string';  // UUID adalah string
    public $incrementing  = false;  // non-auto increment

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'jumlah',
        'harga',
        'diskon',
        'image_url',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga'  => 'decimal:2',
        'diskon' => 'integer',
    ];

    // Generate UUID secara otomatis saat creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_barang)) {
                $model->kode_barang = (string) Str::uuid();
            }
        });
    }
}
