<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaksiRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'kode_transaksi' => 'required|string|unique:transactions,kode_transaksi,' . $this->transaction,
      'product_id'     => 'required|exists:products,id',
      'jumlah'         => 'required|integer|min:1',
      'harga_satuan'   => 'required|numeric|min:0',
      'diskon'         => 'nullable|integer|min:0|max:100',
      'total_beli'     => 'required|numeric|min:0',
      'total_bayar'    => 'required|numeric|min:0',
    ];
  }
}
