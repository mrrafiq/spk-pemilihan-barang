<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ahp;
use App\Models\Aras;
use App\Models\ArasValue;
use App\Models\Session;
use Auth;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Session::orderByDesc('created_at')->where('user_id', Auth::user()->id)->get();
        return view('perhitungan.index', [
            "title" => "Perhitungan",
            "datas" => $datas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('perhitungan.create', [
            "title" => "Pembobotan Kriteria"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $session = new Session;
            $session->name = $request->title;
            $session->user_id = Auth::user()->id;
            $session->save();
        } catch (\Throwable $th) {
            DB::rollback();
            echo '<script type="text/javascript">alert("Penyimpanan session gagal!"); history.back()</script>';
        }


        $kriteria = [
            "kondisi_barang",
            "harga_barang",
            "kebutuhan_orang_lain",
            "waktu_pemakaian",
            "ruang_penyimpanan",
            "kebutuhan_finansial",
        ];
        $kondisi = $request->kondisi; //index 0
        array_unshift($kondisi, 1);

        $harga = $request->harga; //index 1
        array_unshift($harga, 1);
        array_unshift($harga, 1/$kondisi[1]);

        $kebutuhan_orang_lain = $request->kebutuhan_orang_lain; //index 2
        array_unshift($kebutuhan_orang_lain, 1);
        array_unshift($kebutuhan_orang_lain, 1/$harga[2]);
        array_unshift($kebutuhan_orang_lain, 1/$kondisi[2]);

        $waktu_pemakaian = $request->waktu_pemakaian; //index 3
        array_unshift($waktu_pemakaian, 1);
        array_unshift($waktu_pemakaian, 1/$kebutuhan_orang_lain[3]);
        array_unshift($waktu_pemakaian, 1/$harga[3]);
        array_unshift($waktu_pemakaian, 1/$kondisi[3]);

        $ruang_penyimpanan = $request->ruang_penyimpanan; //index 4
        array_unshift($ruang_penyimpanan, 1);
        array_unshift($ruang_penyimpanan, 1/$waktu_pemakaian[4]);
        array_unshift($ruang_penyimpanan, 1/$kebutuhan_orang_lain[4]);
        array_unshift($ruang_penyimpanan, 1/$harga[4]);
        array_unshift($ruang_penyimpanan, 1/$kondisi[4]);

        $kebutuhan_finansial = []; //index 5
        array_unshift($kebutuhan_finansial, 1);
        array_unshift($kebutuhan_finansial, 1/$ruang_penyimpanan[5]);
        array_unshift($kebutuhan_finansial, 1/$waktu_pemakaian[5]);
        array_unshift($kebutuhan_finansial, 1/$kebutuhan_orang_lain[5]);
        array_unshift($kebutuhan_finansial, 1/$harga[5]);
        array_unshift($kebutuhan_finansial, 1/$kondisi[5]);

        $perbandingan = [$kondisi, $harga, $kebutuhan_orang_lain, $waktu_pemakaian, $ruang_penyimpanan, $kebutuhan_finansial];
        // dd($perbandingan);

        // mencari total
        $total = [0, 0, 0, 0, 0, 0];
        for ($i=0; $i < count($perbandingan); $i++) {
            for ($j=0; $j < count($perbandingan[$i]); $j++) {
                $total[$i] += $perbandingan[$j][$i];
            }
        }
        // var_dump($total);

        // langkah 2
        // normalisasi
        $normalisasi = [];
        for ($i=0; $i < count($perbandingan); $i++) {
            $temp_array = [];
            for ($j=0; $j < count($perbandingan[$i]); $j++) {
                $temp_value = $perbandingan[$i][$j]/$total[$j];
                array_push($temp_array, $temp_value);
            }
            array_push($normalisasi, $temp_array);
        }

        // echo '<pre>' . var_export($normalisasi, true) . '</pre>';

        // langkah 3
        // pembobotan
        $bobot = [];
        for ($i=0; $i < count($normalisasi); $i++) {
            $jumlah = 0;
            for ($j=0; $j < count($normalisasi[$i]); $j++) {
                $jumlah += $normalisasi[$i][$j];
            }
            $jumlah = $jumlah/count($perbandingan);
            array_push($bobot, $jumlah);
        }
        // dd($bobot);
        // echo '<pre>' . var_export($bobot, true) . '</pre>';

        // langkah 4
        // validasi CR
        $validasi = [];
        for ($i=0; $i < count($perbandingan); $i++) {
            for ($j=0; $j < count($perbandingan[$i]); $j++) {
                $validasi[$i][$j] = $perbandingan[$j][$i]*$bobot[$i];
            }
        }
        // echo '<pre>' . var_export($validasi, true) . '</pre>';

        $total_validasi = [];
        for ($i=0; $i < count($validasi); $i++) {
            $temp_total = 0;
            for ($j=0; $j < count($validasi[$i]); $j++) {
                $temp_total += $validasi[$j][$i];
            }
            array_push($total_validasi, $temp_total);
        }
        // echo '<pre>' . var_export($total_validasi, true) . '</pre>';

        $validasi_lmax = [];
        for ($i=0; $i < count($total_validasi); $i++) {
            $validasi_lmax [$i] = $total_validasi[$i]/$bobot[$i];
        }
        // echo '<pre>' . var_export($validasi_lmax, true) . '</pre>';
        $total_bobot_lmax = 0;
        for ($i=0; $i < count($validasi_lmax); $i++) {
            $total_bobot_lmax += $validasi_lmax[$i];
        }
        $lmax = $total_bobot_lmax/count($perbandingan);
        // echo '<pre>' . var_export($lmax, true) . '</pre>';

        // Langkah 5
        // mencari nilai CI
        $ci = ($lmax-count($perbandingan))/(count($perbandingan)-1);
        // echo '<pre>' . var_export($ci, true) . '</pre>';

        //Langkah 6
        // mencari nilai CR

        //list nilai index ratio (static)
        $jumlah_kriteria = count($perbandingan);
        $ir = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];
        $cr = $ci/$ir[$jumlah_kriteria-1];
        // echo '<pre>' . var_export($cr, true) . '</pre>';

        /*
        - jika nilai CR > 0.1 maka input ditolak -> beri pesan berupa alert ke frontend
        "input anda tidak konsisten"
        - jika CR < 0.1 maka data $bobot masukkan ke DB
        */
        if ($cr > 0.1) {
            DB::rollback();
            echo '<script type="text/javascript">alert("input anda tidak konsisten"); history.back()</script>';
        }else{
            try {
                for ($i=0; $i < count($perbandingan); $i++) {
                    $ahp = new Ahp;
                    $ahp->session_id = $session->id;
                    $ahp->kriteria = $kriteria[$i];
                    $ahp->bobot = $bobot[$i];
                    $ahp->save();
                }
                DB::commit();
                return redirect('/perhitungan');
            } catch (\Throwable $th) {
                DB::rollback();
                echo '<script type="text/javascript">alert("Terjadi kesalahan!"); history.back()</script>';
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $session = Session::where('id', $id)->first();
        $ahp = Ahp::where('session_id', $id)->orderByDesc('bobot')->get();
        $aras = Aras::with('barang')->where('session_id', $id)->orderBy('rank', 'asc')->get();
        $aras_value = ArasValue::where('session_id', $id)->get();

        return view('perhitungan.show', [
            "title" => "Detail Perhitungan ".$session->name,
            "ahp" => $ahp,
            "aras" => $aras,
            'aras_value' => $aras_value
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
