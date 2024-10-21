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
        $buku = Buku::with('kategori')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Buku berhasil ditampilkan',
            'data' => $buku->map(function ($data) {
                return [
                    'id' => $data->id,
                    'judul' => $data->judul,
                    'penulis' => $data->penulis,
                    'harga' => $data->harga,
                    'stok' => $data->stok,
                    'kategori_id' => $data->kategori->nama_kategori
                ];
            })
        ]);
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

        return response()->json([
            'status' => false,
            'message' => 'Data Buku gagal ditambahkan'
        ], 404);
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

        return response()->json([
            'status' => false,
            'message' => 'Data Buku gagal diperbarui'
        ], 404);
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

    public function searchByKategori($kategori_id)
    {
        $buku = Buku::where('kategori_id', $kategori_id)->get();

        if ($buku->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data Buku berhasil ditampilkan',
                'data' => $buku->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'judul' => $data->judul,
                        'penulis' => $data->penulis,
                        'harga' => $data->harga,
                        'stok' => $data->stok,
                        'kategori_id' => $data->kategori->nama_kategori
                    ];
                })
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data Buku tidak ditemukan'
        ], 404);
    }

    public function searchByJudul($judul)
    {
        $buku = Buku::where('judul', 'like', '%' . $judul . '%')->get();

        if ($buku->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data Buku berhasil ditampilkan',
                'data' => $buku->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'judul' => $data->judul,
                        'penulis' => $data->penulis,
                        'harga' => $data->harga,
                        'stok' => $data->stok,
                        'kategori_id' => $data->kategori->nama_kategori
                    ];
                })
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data Buku tidak ditemukan'
        ], 404);
    }
}