<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;


class ProductApiController extends Controller
{

    public function index()
    {
        try {
            $products = Product::with('images')->get();

            return response()->json([
                'message' => 'Products fetched successfully',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpg,jpeg,png' 
            ]);

            DB::beginTransaction();

            // Create the product
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            $storedImages = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $originalName = $image->getClientOriginalName();
                        $path = $image->store('products', 'public');

                        ProductImage::create([
                            'product_id' => $product->id,
                            'img_path' => $path,
                        ]);

                        $storedImages[] = [
                            'original_name' => $originalName,
                            'stored_path' => $path
                        ];
                    }
                }

                DB::commit();

                return response()->json([
                    'message' => 'Product and images uploaded successfully',
                    'product' => $product,
                    'images' => $storedImages
                ], 201);
            }

            DB::rollBack();
            return response()->json(['message' => 'No valid images found'], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function show($id)
    {
        try {

            $product = Product::with('images')->findOrFail($id);
            return response()->json([
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Product not found', 'error' => $e->getMessage()], 404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'price' => 'nullable|numeric|min:0',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpg,jpeg,png'
            ]);

            $product = Product::findOrFail($id);

            if (isset($validated['name'])) {
                $product->name = $validated['name'];
            }

            if (isset($validated['price'])) {
                $product->price = $validated['price'];
            }

            $product->save();

            $storedImages = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('products', 'public');

                        ProductImage::create([
                            'product_id' => $product->id,
                            'img_path' => $path,
                        ]);

                        $storedImages[] = [
                            'original_name' => $image->getClientOriginalName(),
                            'stored_path' => $path
                        ];
                    }
                }
            }

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
                'new_images' => $storedImages
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['message' => 'Product deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Delete failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroyimg($id)
    {
        try {
            $product = ProductImage::findOrFail($id);
            $product->delete();
            return response()->json(['message' => 'Product Image deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Delete failed', 'error' => $e->getMessage()], 500);
        }
    }
}
