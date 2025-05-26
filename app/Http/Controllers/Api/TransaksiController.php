<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaksi\StoreTransactionRequest;
use App\Http\Requests\Transaksi\StoreTransaksiRequest;
use App\Http\Requests\Transaksi\UpdateTransactionRequest;
use App\Http\Requests\Transaksi\UpdateTransaksiRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransaksiResource;
use App\Models\Transaction;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;

class TransaksiController extends Controller
{
  // GET /api/Transaksis
  public function index(): JsonResponse
  {
    $transaksis = Transaksi::with('product')->latest()->get();
    return response()->json([
      'success' => true,
      'data'    => TransaksiResource::collection($transaksis),
    ]);
  }

  // POST /api/Transaksis
  public function store(StoreTransaksiRequest $request): JsonResponse
  {
    $transaksi = Transaksi::create($request->validated());

    return response()->json([
      'success' => true,
      'message' => 'Transaksi berhasil disimpan',
      'data'    => new TransaksiResource($transaksi),
    ], 201);
  }

  // GET /api/Transaksis/{id}
  public function show(Transaksi $transaksi): JsonResponse
  {
    return response()->json([
      'success' => true,
      'data'    => new TransaksiResource($transaksi->load('product')),
    ]);
  }

  // PUT/PATCH /api/Transaksis/{id}
  public function update(UpdateTransaksiRequest $request, Transaksi $transaksi): JsonResponse
  {
    $transaksi->update($request->validated());

    return response()->json([
      'success' => true,
      'message' => 'Transaksi berhasil diperbarui',
      'data'    => new TransaksiResource($transaksi->load('product')),
    ]);
  }

  // DELETE /api/Transaksis/{id}
  public function destroy(Transaksi $transaksi): JsonResponse
  {
    $transaksi->delete();

    return response()->json([
      'success' => true,
      'message' => 'Transaksi berhasil dihapus',
    ]);
  }
}
