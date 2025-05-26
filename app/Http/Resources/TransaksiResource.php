<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TransaksiResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id'           => $this->id,
      'product_id'   => $this->product_id,
      'nama_barang'  => $this->product->nama_barang ?? null,
      'jumlah'       => $this->jumlah,
      'harga_satuan' => $this->harga_satuan,
      'diskon'       => $this->diskon,
      'total_beli'   => $this->total_beli,
      'total_bayar'  => $this->total_bayar,
      'created_at'   => $this->created_at->toDateTimeString(),
    ];
  }
}
