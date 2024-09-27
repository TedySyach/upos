<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan Auth diimpor jika diperlukan

class MasterDataController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil user_id pengguna yang sedang login
        $userId = Auth::id(); // Bisa juga auth()->id();

        // Ambil kategori sesuai user_id
        $categories = Category::where('user_id', $userId)->get();

        // Mendapatkan kategori_id dari query string (jika ada)
        $categoryId = $request->query('category_id');

        // Ambil produk dengan kategori terkait menggunakan eager loading
        $productsQuery = Product::where('user_id', $userId)->with('category');

        // Jika kategori dipilih, filter produk berdasarkan kategori
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        // Mendapatkan query pencarian dari parameter pencarian
        $search = $request->query('search');

        // Jika ada query pencarian, filter produk berdasarkan nama
        if ($search) {
            $productsQuery->where('name', 'like', '%' . $search . '%');
        }

        $products = $productsQuery->get();

        // Melempar data ke view 'pages.master-data.index'
        return view('pages.master-data.index', compact('categories', 'products', 'search'));
    }

    public function create()
    {
        // Ambil semua kategori dari database yang sesuai dengan user_id pengguna yang sedang login (jika ada user_id pada kategori)
        $userId = Auth::id();
        $categories = Category::where('user_id', $userId)->get();

        return view('pages.master-data.create-product', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil user_id dari pengguna yang sedang login
        $data = $request->all();
        $data['price'] = str_replace('.', '', $data['price']); // Hilangkan titik dari harga
        $data['user_id'] = Auth::id(); // Tambahkan user_id


        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->file('image')->store('products', 'public');
            $data['image'] = $filename;
        }

        // Simpan data produk
        Product::create($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('masterdata.index')->with('success', 'Product successfully created');
    }
}
