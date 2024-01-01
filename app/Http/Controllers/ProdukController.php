<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function tampil_data_produk()
    {
        $data_produk = Produk::get();
        return response()->json([
            'produk' => $data_produk
        ], 200);
    }
}
