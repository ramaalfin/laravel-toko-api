<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Produk Ditemukan',
            'data' => Produk::where('userId', Auth::user()->id)->orderBy('created_at', 'desc')->get()
        ], 200);
    }

    public function show($id)
    {
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Produk Ditemukan',
            'data' => Produk::where('id', $id)->get()
        ], 200);
    }

    public function store(Request $request)
    {
        $attrs = $request->validate([
            'kodeProduk'  => 'required|string',
            'namaProduk'  => 'required|string',
            'hargaProduk' => 'required|string'
        ]);

        $produk = Produk::create([
            'kodeProduk'  => $attrs['kodeProduk'],
            'namaProduk'  => $attrs['namaProduk'],
            'hargaProduk' => $attrs['hargaProduk'],
            'userId' => auth()->user()->id,
        ]);

        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Produk Berhasil Ditambahkan',
            'data' => $produk
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);

        if(!$produk)
        {
            return response([
                'code' => 403,
                'message' => 'Produk Tidak Ditemukan'
            ], 403);
        }

        if($produk->userId != auth()->user()->id)
        {
            return response([
                'code' => 403,
                'message' => "Permission Denied"
            ], 403);
        }

        // validasi
        $attrs = $request->validate([
            'kodeProduk'  => 'required|string',
            'namaProduk'  => 'required|string',
            'hargaProduk' => 'required|string'
        ]);

        $produk->update([
            'kodeProduk'  => $attrs['kodeProduk'],
            'namaProduk'  => $attrs['namaProduk'],
            'hargaProduk' => $attrs['hargaProduk']
        ]);

        return response([
            'code' => 200,
            'message' => 'Produk Berhasil Diupdate',
            'data' => $produk
        ], 200);
    }

    public function destroy($id){
        $produk = Produk::find($id);

        if (!$produk) 
        {
            return response([
                'code' => 403,
                'message' => 'Produk Tidak Ditemukan'
            ], 403);
        }

        if ($produk->userId != auth()->user()->id) {
            return response([
                'code' => 403,
                'message' => "Permission Denied"
            ]);
        }

        $produk->delete();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Produk Berhasil Dihapus',
        ], 200);
    }
}
