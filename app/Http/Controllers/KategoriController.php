<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Kategori::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|unique:kategoris']);
        $kategori = Kategori::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 200);

        return response()->json([
            'status' => false,
            'message' => 'Data Kategori gagal ditambahkan'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data Kategori berhasil ditampilkan',
            'data' => $kategori
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Kategori berhasil diperbarui',
            'data' => $kategori
        ], 200);

        return response()->json([
            'status' => false,
            'message' => 'Data Kategori gagal diperbarui'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return response()->json([
            'message' => 'Data Kategori telah dihapus',
            'data' => $kategori
        ], 204);
    }
}
