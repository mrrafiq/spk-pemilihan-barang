<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ahp;
use App\Models\Aras;
use App\Models\ArasValue;
use App\Models\Barang;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArasController extends Controller
{
    public function create($id)
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

        $aras_value = ArasValue::where('session_id', $id)->orderBy('barang_id', "ASC")->get();
        // group by barang_id and each barang_id group depends on order of criteria
        $grouped = [];
        foreach ($barang as $key => $value) {
            $temp = [];
            foreach ($kriteria as $key2 => $value2) {
                foreach ($aras_value as $key3 => $value3) {
                    if ($value->id == $value3->barang_id && $value2 == $value3->criteria) {
                        $temp [] = $value3;
                    }
                }
            }
            $grouped [] = $temp;
        }

        // cek apakah user sudah pernah melakukan perhitungan di session ini
        $check = Aras::where('session_id', $id)->count();
        // if ($check > 0) {
        //     // return dengan alert message "Anda sudah pernah melakukan perhitungan pada session ini"
        //     echo '<script type="text/javascript">alert("Anda sudah pernah melakukan perhitungan pada session ini"); history.back()</script>';
        // }

        // dd($grouped);
        return view('perhitungan.aras.create', [
            "title" => "Perhitungan ARAS",
            "barang" => $barang,
            "id" => $id,
            "kriteria" => $kriteria,
            'aras_value' => $grouped,
            'check' => $check
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            "kondisi_barang" => "required|between:1,10",
            "harga_barang" => "required|between:1,10",
            "kebutuhan_orang_lain" => "required|between:1,10",
            "waktu_pemakaian" => "required|between:1,10",
            "ruang_penyimpanan" => "required|between:1,10",
            "kebutuhan_finansial" => "required|between:1,10",
        ]);
        $all_request = $request->all();
        $data = $all_request;
        unset($data['_token']);
        // dd($data);

        $data_barang = Barang::where('user_id', Auth::user()->id)->orderBy('id', 'asc')->get();
        // dd($data_barang);

        $kriteria = array_keys($data);
        // dd($kriteria);

        DB::beginTransaction();
        // cek apakah nilai sudah pernah tersimpan di tabel aras_value
        $check = ArasValue::where('session_id', $id)->count();
        if($check > 0){
            try {
                ArasValue::where('session_id', $id)->delete();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        try {
            foreach ($data as $key => $value) {
                foreach ($data_barang as $key2 => $value2) {
                    $prepare_data = [
                        "session_id" => intval($id),
                        "barang_id" => $value2->id,
                        "criteria" => $key,
                        "value" => intval($value[$key2])
                    ];
                    // dd($prepare_data);
                    $insert_data = ArasValue::create($prepare_data);
                }
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        DB::commit();
        // return to previous page and send flash message request is successful
        return redirect('/perhitungan/detail/'.$id)->with(['success' => 'Data berhasil disimpan!']);

    }

    public function beginCalculate($id)
    {
        //cek apakah sudah pernaj menginput nilai aras
        $check = ArasValue::where('session_id', $id)->count();
        if ($check == 0) {
            echo '<script type="text/javascript">alert("Anda belum menginput nilai ARAS"); history.back()</script>';
        }

        // cek apakah sudah pernah melakukan perhitungan di session ini
        $check = Aras::where('session_id', $id)->count();
        if ($check > 0) {
            // return dengan alert message "Anda sudah pernah melakukan perhitungan pada session ini"
            echo '<script type="text/javascript">alert("Anda sudah pernah melakukan perhitungan pada session ini"); history.back()</script>';
        }
        DB::beginTransaction();
        try {
            $calculate_aras = self::calculate($id);
            if (!$calculate_aras) {
                echo '<script type="text/javascript">alert("Terjadi kesalahan!"); history.back()</script>';
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        return redirect('/perhitungan/detail/'.$id)->with(['success' => 'Perhitungan ARAS berhasil dilakukan!']);
    }

    private static function calculate($session_id)
    {
        $kriteria = [
            "kondisi_barang", // benefit
            "harga_barang", // benefit
            "kebutuhan_orang_lain", // benefit
            "waktu_pemakaian", // cost
            "ruang_penyimpanan", // cost
            "kebutuhan_finansial", // benefit
        ];

        $data_barang = Barang::where('user_id', Auth::user()->id)->get();

        $sorted_value = [];
        foreach ($data_barang as $key => $value) {
            $temp = [];
            foreach ($kriteria as $key2 => $value2) {
                $get_value = ArasValue::where('session_id', $session_id)
                            ->where('criteria', $value2)
                            ->where('barang_id', $value->id)
                            ->first();
                array_push($temp, $get_value->value);
            }
            array_push($sorted_value, $temp);
        }
        // dd($sorted_value);

        $cost = [3,4];
        // ambil nilai optimum dari setiap kriteria
        // jika benefit maka ambil nilai max
        // jika cost maka ambil nilai min
        $optimum = [];
        for ($i=0; $i < count($kriteria); $i++) {
            $temp = [];
            foreach ($sorted_value as $key2 => $value2) {
                $temp [] = $value2[$i];
            }
            if (in_array($i, $cost)) {
                $optimum [] = min($temp);
            }else{
                $optimum [] = max($temp);
            }
        }
        // dd($optimum);
        array_unshift($sorted_value, $optimum);
        // dd($sorted_value);

        // normalisasi matriks berdasarkan kriteria cost dan benefit
        // membuat pembagi (divider)
        // pembagi dibuat sum(kolom) atau sum(1/kolom) yang dituju
        $divider = [];
        foreach($kriteria as $key => $value){
            $temp = [];
            if (in_array($key, $cost)) {
                foreach ($sorted_value as $key2 => $value2) {
                    $temp[] = 1/$value2[$key];
                }
            }else{
                foreach ($sorted_value as $key2 => $value2) {
                    $temp[] = $value2[$key];
                }
            }
            array_push($divider, $temp);
        }
        // dd($divider);

        $normalized = [];
        for ($i=0; $i < count($sorted_value); $i++) {
            $temp = [];
            for ($j=0; $j < count($kriteria); $j++) {
                if (in_array($j, $cost)) {
                    $calculate = (1/$sorted_value[$i][$j])/array_sum($divider[$j]);
                }else{
                    $calculate = $sorted_value[$i][$j]/array_sum($divider[$j]);
                }
                $temp [] = $calculate;
            }
            array_push($normalized, $temp);
        }
        // dd($normalized);

        // Matriks Ternormalisasi Terbobot
        // mengalikan setiap nilai normalisasi dengan bobot yang didapat dari metode ahp
        $bobot = Ahp::where('session_id', $session_id)->get()->pluck('bobot')->toArray();
        for ($i=0; $i < count($normalized); $i++) {
            for ($j=0; $j < count($bobot); $j++) {
                $normalized[$i][$j] = $normalized[$i][$j] * $bobot[$j];
            }
        }
        // dd($normalized);

        // mencari nilai fungsi optimum dari masing-masing alternatif
        // menjumlahkan nilai normalisasi terbobot untuk setiap alternatif
        $f_optimum = [];
        foreach ($normalized as $key => $value) {
            $f_optimum []= array_sum($value);
        }
        // dd($f_optimum);

        // hilangkan data $f_optimum[0] karena tidak digunakan untuk perbandingan
        unset($f_optimum[0]);

        // mendapatkan data barang berdasarkan session
        $data_barang = ArasValue::where('session_id', $session_id)
                        ->select('barang_id')
                        ->distinct()
                        ->get();

        $collect_data = [];
        foreach ($data_barang as $key => $value) {
            $collect_data []= [
                "barang_id" => $value->barang_id,
                "utility_point" => $f_optimum[$key+1]
            ];
        }
        // dd($collect_data);
        // mengurutkan data dari nilai yang terbesar ke terkecil
        rsort($f_optimum);

        $prepare_data = [];
        for ($i=0; $i < count($f_optimum); $i++) {
            for ($j=0; $j < count($collect_data); $j++) {
                if ($collect_data[$j]['utility_point'] == $f_optimum[$i]) {
                    $prepare_data [] = [
                        "session_id" => $session_id,
                        "barang_id" => $collect_data[$j]["barang_id"],
                        "utility_point" => $f_optimum[$i],
                        "rank" => $i+1,
                    ];
                    break;
                }
            }

        }

        // dd($prepare_data);
        // masukkan data yang telah berurutan sesuai ranking ke db
        try {
            DB::table('aras')->insert($prepare_data);
        } catch (\Throwable $th) {
            throw $th;
        }
        return true;
    }
}
