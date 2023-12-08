<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use Illuminate\Http\Request;

class FakturController extends Controller
{
    public function get_data_faktur()
    {
        $data_faktur = Faktur::with('relasi_pelanggan')->get();
        return response()->json([
            'faktur' => $data_faktur
        ], 200);
    }
}
