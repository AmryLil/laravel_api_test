<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
  use HasFactory;

  protected $table = 'transaksi';

  protected $fillable = [
    'product_id',
    'jumlah',
    'harga_satuan',
    'diskon',
    'total_beli',
    'total_bayar',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
