<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Ambil pengguna yang sedang autentikasi

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        if ($user->roles === 'user') {
            // Jika role adalah 'user', ambil produk berdasarkan ID
            $products = Product::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        } elseif ($user->roles === 'kasir') {
            // Jika role adalah 'kasir', ambil produk berdasarkan user_id
            $products = Product::where('user_id', $user->user_id)->orderBy('id', 'desc')->get();
        } else {
            // Jika role tidak dikenali, bisa mengembalikan pesan kesalahan
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Products retrieved successfully.',
                'data' => $products
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
