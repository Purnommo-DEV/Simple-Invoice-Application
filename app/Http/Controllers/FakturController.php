<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use Illuminate\Http\Request;

class FakturController extends Controller
{
    public function tampil_data_faktur()
    {
        $data_faktur = Faktur::with('relasi_pelanggan')->get();
        return response()->json([
            'faktur' => $data_faktur
        ], 200);
    }

    public function cari_data_faktur(Request $request)
    {
        $pencarian = $request->get("cari");

        if ($pencarian != null) {
            $data_faktur = Faktur::with('relasi_pelanggan')
                ->where('id', 'LIKE', "%$pencarian")
                ->get();
            return response()->json([
                'faktur' => $data_faktur
            ], 200);
        } else {
            return $this->tampil_data_faktur();
        }


        $data_faktur = Faktur::with('relasi_pelanggan')->get();
        return response()->json([
            'faktur' => $data_faktur
        ], 200);
    }
}
