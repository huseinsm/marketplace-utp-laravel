<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. GET ALL
    public function index() {
        return response()->json(Category::all(), 200);
    }

    // 2. CREATE
    public function store(Request $request) {
        $category = Category::create($request->all());
        return response()->json(['message' => 'Kategori berhasil dibuat', 'data' => $category], 201);
    }

    // 3. SHOW BY ID
    public function show($id) {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json($category, 200);
    }
}