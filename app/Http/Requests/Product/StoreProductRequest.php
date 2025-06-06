<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_barang' => 'nullable|string|max:50|unique:products,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'deskripsi'   => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
            'diskon'      => 'nullable|integer|min:0|max:100',
            'image_url'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
