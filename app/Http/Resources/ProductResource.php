<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'                   => $this->id,
            'kode_barang'          => $this->kode_barang,
            'nama_barang'          => $this->nama_barang,
            'jumlah'               => $this->jumlah,
            'harga'                => (float) $this->harga,
            'diskon'               => $this->diskon,
            'harga_setelah_diskon' => round($this->harga - ($this->harga * $this->diskon / 100), 2),
            'image_url'            => $this->image_url,
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }
}
