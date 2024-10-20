<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Buku::with('kategori')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'harga' => 'required|numeric|min:1000',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);
        $buku = Buku::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data Buku berhasil ditambahkan',
            'data' => $buku
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data Buku berhasil ditampilkan',
            'data' => $buku
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->stok = $request->stok;
        $buku->kategori_id = $request->kategori_id;
        $buku->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Buku berhasil diperbarui',
            'data' => $buku
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return response()->json([
            'message' => 'Data Buku telah dihapus',
            'data' => $buku
        ], 204);
    }
}
