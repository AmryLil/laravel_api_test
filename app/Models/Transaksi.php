<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
  use HasFactory;

  protected $table      = 'transaksi';
  protected $primaryKey = 'id';
  public $incrementing  = false;
  protected $keyType    = 'string';

  protected $fillable = [
    'id',
    'product_id',
    'jumlah',
    'harga_satuan',
    'diskon',
    'total_beli',
    'total_bayar',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (empty($model->id)) {
        $model->id = (string) Str::uuid();
      }
    });
  }

  protected $casts = [
    'jumlah'       => 'integer',
    'harga_satuan' => 'decimal:2',
    'diskon'       => 'integer',
    'total_beli'   => 'decimal:2',
    'total_bayar'  => 'decimal:2',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id', 'kode_barang');
  }
}
