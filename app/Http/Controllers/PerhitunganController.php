<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ahp;
use App\Models\Aras;
use App\Models\Kriteria;
use App\Models\ArasValue;
use App\Models\Session;
use Auth;
use Session as sess;
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
        $kriteria = Kriteria::where('user_id', Auth::user()->id)->get();
        return view('perhitungan.create', [
            "title" => "Pembobotan Kriteria",
            "kriteria" => $kriteria
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

        $kriteria = Kriteria::where('user_id', Auth::user()->id)->orderBy('id', 'asc')->get()->pluck('nama_kriteria')->toArray();
        foreach ($kriteria as $key => $value) {
            $kriteria[$key] = strtolower(str_replace(' ', '_', $value));
        }

        $req = $request->all();
        // remove _token an title from $req array
        unset($req['_token']);
        unset($req['title']);

        // kriteria terakhir yang tidak ada di $req perlu ditambahakn di akhir array
        $req[$kriteria[count($kriteria)-1]] = [];

        $values = [];
        foreach ($req as $key => $value) {
            $values[] = $value;
        }

        // mengisi index array dengan nilai 1 atau kebalikan dari pembanding
        for ($i=0; $i < count($values); $i++) {
            for ($j=0; $j < count($values); $j++) {
                if ($j == $i) {
                    array_splice($values[$i],$j,0,1);
                }
                if($j > $i){
                    $temp = 1/$values[$i][$j];
                    array_splice($values[$j],$i,0, $temp);
                }
            }
        }

        $perbandingan = $values;
        // dd($perbandingan);

        // mencari total
        $total = [];
        foreach ($kriteria as $key => $value) {
            $total[] = 0;
        }
        for ($i=0; $i < count($perbandingan); $i++) {
            for ($j=0; $j < count($perbandingan[$i]); $j++) {
                $total[$i] += $perbandingan[$j][$i];
            }
        }
        // dd($total);

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
            $cr = number_format($cr,2);
            echo "<script type='text/javascript'>alert('input anda tidak konsisten. Nilai CR = $cr'); history.back()</script>";
            // return redirect()->back()->with('error', 'Input anda tidak konsisten!');
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
                sess::flash('success', 'Perhitungan AHP berhasil. Nilai CR = '.$cr);
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
