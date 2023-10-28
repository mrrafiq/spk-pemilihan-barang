<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Session;
use Auth;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kriteria::where('user_id', Auth::user()->id)->get();
        return view('kriteria.index', [
            "datas" => $data,
            "title" => "Data Krteria"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create', [
            "title" => "Tambah Krteria"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|unique:kriteria,nama_kriteria',
        ]);
        $nama= $request->nama_kriteria;
        $deskripsi = $request->deskripsi;

        $kriteria = new Kriteria;
        $kriteria->nama_kriteria = $nama;
        $kriteria->user_id = Auth::user()->id;
        $kriteria->deskripsi = $deskripsi;
        $kriteria->save();

        Session::flash('success', 'Data berhasil disimpan!');
        return redirect('/kriteria');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Kriteria::where('id', $id)->first();
        return view('kriteria.edit', [
            'data' => $data,
            'title' => 'Edit Kriteria'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->user_id = Auth::user()->id;
        $kriteria->nama_kriteria = $request-> nama_kriteria;
        $kriteria->deskripsi = $request-> deskripsi;
        $kriteria->save();
        return redirect()->route('kriteria.index')->with('success','kriteria berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Kriteria::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('kriteria.index')
                ->with([
                    'success' => 'Data berhasil dihapus '
                ]);
        } else {
            return redirect()
                ->route('kriteria.index')
                ->with([
                    'error' => 'Terjadi kesalahan, silahkan coba lagi!'
                ]);
        }
    }
}
