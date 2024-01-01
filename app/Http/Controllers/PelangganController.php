<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function tampil_data_pelanggan()
    {
        $data_pelanggan = Pelanggan::get();
        return response()->json([
            'pelanggan' => $data_pelanggan
        ], 200);
    }
}
