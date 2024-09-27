<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan user yang sedang login
        $currentUser = auth::user();

        // Query untuk mengambil semua kasir yang terikat dengan user_id dari pengguna yang sedang login
        $kasir = User::where('roles', 'kasir')
            ->where('user_id', $currentUser->id)
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan created_at
            ->paginate(5);

        // Mengirim data kasir ke tampilan
        return view('pages.cashiers.index', compact('kasir'));
    }

    public function create()
    {
        return view('pages.cashiers.create');
    }

    public function store(StoreUserRequest $request)
    {

        $data = $request->all();

        // Hash password
        $data['password'] = Hash::make($request->password);

        // Tambahkan user_id dari pengguna yang sedang login
        $data['user_id'] = Auth::id();

        // Buat kasir baru
        \App\Models\User::create($data);

        return redirect()->route('cashiers.index')->with('success', 'User successfully created');
    }

    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('pages.cashiers.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        $user = \App\Models\User::findOrFail($id);
        $user->update($data);
        return redirect()->route('cashiers.index')->with('success', 'User successfully updated');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('cashiers.index')->with('success', 'User successfully deleted');
    }
}
