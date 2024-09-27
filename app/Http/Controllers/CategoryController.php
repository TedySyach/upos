<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function create()
    {
        return view('pages.master-data.create-category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Category::create($data);

        return redirect()->route('masterdata.index')->with('success', 'Category successfully created');
    }
}
