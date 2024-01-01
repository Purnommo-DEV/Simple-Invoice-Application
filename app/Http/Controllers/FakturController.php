<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use App\Models\FakturBarang;
use App\Models\Penghitung;
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

    public function baru_data_faktur(Request $request)
    {
        $penghitung = Penghitung::where('key', 'invoice')->first();
        $acak = Penghitung::where('key', 'invoice')->first();

        $faktur = Faktur::orderBy('id', 'DESC')->first();

        if ($faktur) {
            $faktur = $faktur->id + 1;
            $penghitungs = $penghitung->value + $faktur;
        } else {
            $penghitungs = $penghitung->value;
        }

        // $formData -> variable yang akan dikirim ke VIEW yg berisikan kolom/inputan apa saja yang akan diisi oleh pengguna
        $formData = [
            'pelanggan' => null,
            'pelanggan_id' => null,
            'nomor' => $penghitung->prefix . $penghitungs,
            'pelanggan_id' => null,
            'tanggal' => date('Y-m-d'),
            'batas_waktu' => date('Y-m-d'),
            'refrensi' => null,
            'syarat_dan_ketentuan' => "Syarat dan Ketentuan",
            'diskon' => 0,
            'barang' => [
                [
                    'produk_id' => null,
                    'produk' => null,
                    'harga_satuan' => 0,
                    'kuantitas' => 1
                ]
            ]
        ];
        return response()->json($formData);
    }

    public function tambah_data_faktur(Request $request)
    {
        $faktur_barang = $request->input('faktur_barang');

        $data_faktur['sub_total'] = $request->input("subtotal");
        $data_faktur['total'] = $request->input("total");
        $data_faktur['pelanggan_id'] = $request->input("pelanggan_id");
        $data_faktur['tanggal'] = $request->input("tanggal");
        $data_faktur['batas_waktu'] = $request->input("batas_waktu");
        $data_faktur['nomor'] = $request->input("nomor");
        $data_faktur['referensi'] = $request->input("referensi");
        $data_faktur['diskon'] = $request->input("diskon");
        $data_faktur['syarat_dan_ketentuan'] = $request->input("syarat_dan_ketentuan");

        $faktur = Faktur::create($data_faktur);

        foreach (json_decode($faktur_barang) as $barang) {
            $data_barang['produk_id'] = $barang->id;
            $data_barang['faktur_id'] = $faktur->id;
            $data_barang['kuantitas'] = $barang->kuantitas;
            $data_barang['harga_satuan'] = $barang->harga_satuan;

            FakturBarang::create($data_barang);
        }
    }

    public function faktur_detail($id)
    {
        $data_faktur = Faktur::with('relasi_pelanggan')->find($id);
        return response()->json([
            'faktur_detail' => $data_faktur
        ], 200);
    }

    public function list_barang_faktur($faktur_id)
    {
        $data_barang_faktur = FakturBarang::with('relasi_produk')->where('faktur_id', $faktur_id)->orderBy('id', 'DESC')->get();
        return response()->json([
            'list_barang_faktur' => $data_barang_faktur
        ], 200);
    }
}
