<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ahp;
use App\Models\Aras;
use App\Models\Barang;
use Auth;

class ArasController extends Controller
{
    public function create() 
    {
        $kriteria = [
            "kondisi_barang",
            "harga_barang",
            "kebutuhan_orang_lain",
            "waktu_pemakaian",
            "ruang_penyimpanan",
            "kebutuhan_finansial",
        ];

        $barang = Barang::where('user_id', Auth::user()->id)->get();
        return view('perhitungan.aras.create', [
            "title" => "Perhitungan ARAS",
            "barang" => $barang,
            "kriteria" => $kriteria,
        ]);
    }

    public function store(Request $request)
    {

    }
}
