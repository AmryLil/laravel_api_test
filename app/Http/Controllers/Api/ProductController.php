<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    protected $cloudinary;

    public function __construct(Cloudinary $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    public function index(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $size = $request->input('size', 10);

            $products = Product::paginate($size);

            return response()->json([
                'data'       => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'total_pages'  => $products->lastPage(),
                    'total_items'  => $products->total(),
                    'per_page'     => $products->perPage(),
                ]
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch products'], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            Log::info('Validated data:', $data);

            // Upload gambar ke Cloudinary
            if ($request->hasFile('image_url')) {
                Log::info('File detected, attempting Cloudinary upload');

                try {
                    $file = $request->file('image_url');
                    Log::info('File details:', [
                        'original_name' => $file->getClientOriginalName(),
                        'size'          => $file->getSize(),
                        'mime_type'     => $file->getMimeType()
                    ]);

                    // Menggunakan API Cloudinary yang baru
                    $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                        'folder'        => 'products',
                        'resource_type' => 'auto'
                    ]);

                    $data['image_url'] = $result['secure_url'];

                    Log::info('Cloudinary upload successful:', ['url' => $result['secure_url']]);
                } catch (Exception $cloudinaryError) {
                    Log::error('Cloudinary upload failed:', [
                        'error' => $cloudinaryError->getMessage()
                    ]);
                    throw new Exception('Failed to upload image: ' . $cloudinaryError->getMessage());
                }
            }

            // Simpan ke database
            $product = Product::create($data);

            return response()->json([
                'message' => 'Product created successfully',
                'data'    => new ProductResource($product)
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create product',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data'    => new ProductResource($product)
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving product: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to retrieve product'], 500);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $data = $request->validated();

            // Jika ada file gambar baru untuk diupdate
            if ($request->hasFile('image_url')) {
                Log::info('New file detected for update, attempting Cloudinary upload');

                try {
                    $file = $request->file('image_url');

                    // Upload gambar baru
                    $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                        'folder'        => 'products',
                        'resource_type' => 'auto'
                    ]);

                    $data['image_url'] = $result['secure_url'];

                    // Optional: Hapus gambar lama dari Cloudinary
                    if ($product->image_url) {
                        try {
                            // Extract public_id dari URL lama untuk menghapus
                            $oldPublicId = $this->extractPublicIdFromUrl($product->image_url);
                            if ($oldPublicId) {
                                $this->cloudinary->uploadApi()->destroy($oldPublicId);
                            }
                        } catch (Exception $deleteError) {
                            Log::warning('Failed to delete old image from Cloudinary: ' . $deleteError->getMessage());
                        }
                    }

                    Log::info('Cloudinary update upload successful:', ['url' => $result['secure_url']]);
                } catch (Exception $cloudinaryError) {
                    Log::error('Cloudinary upload failed during update:', [
                        'error' => $cloudinaryError->getMessage()
                    ]);
                    throw new Exception('Failed to upload new image: ' . $cloudinaryError->getMessage());
                }
            }

            $product->update($data);

            return response()->json([
                'message' => 'Product updated successfully',
                'data'    => new ProductResource($product)
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            // Hapus gambar dari Cloudinary sebelum menghapus produk
            if ($product->image_url) {
                try {
                    $publicId = $this->extractPublicIdFromUrl($product->image_url);
                    if ($publicId) {
                        $this->cloudinary->uploadApi()->destroy($publicId);
                        Log::info('Image deleted from Cloudinary:', ['public_id' => $publicId]);
                    }
                } catch (Exception $deleteError) {
                    Log::warning('Failed to delete image from Cloudinary: ' . $deleteError->getMessage());
                    // Continue with product deletion even if image deletion fails
                }
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete product'], 500);
        }
    }

    /**
     * Extract public_id from Cloudinary URL for deletion
     */
    private function extractPublicIdFromUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        // Parse URL untuk mendapatkan public_id
        // Format URL Cloudinary: https://res.cloudinary.com/{cloud_name}/image/upload/v{version}/{public_id}.{format}
        $parsedUrl = parse_url($url);
        $path      = $parsedUrl['path'] ?? '';

        // Split path dan ambil bagian setelah /upload/
        $pathParts = explode('/upload/', $path);
        if (count($pathParts) < 2) {
            return null;
        }

        $afterUpload = $pathParts[1];

        // Remove version (v1234567890) jika ada
        $afterUpload = preg_replace('/^v\d+\//', '', $afterUpload);

        // Remove file extension
        $publicId = pathinfo($afterUpload, PATHINFO_DIRNAME) . '/' . pathinfo($afterUpload, PATHINFO_FILENAME);

        // Clean up
        $publicId = ltrim($publicId, './');

        return $publicId;
    }
}
