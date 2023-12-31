<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Session;
use Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::where('user_id', Auth::user()->id)->get();
        return view('barang.index', [
            "datas" => $data,
            "title" => "Data Barang"
        ]);
    }

    public function create()
    {
        return view('barang.create', [
            "title" => "Tambah Barang"
        ]);
    }

    public function store(Request $request)
    {
        $nama= $request->nama_barang;
        $harga = $request->harga;
        $foto = $request->file('foto');
        $path = NULL;
        if ($foto != null) {
            $originalFileName = now()->timestamp."_".$foto->getClientOriginalName();
            $path = $request->file('foto')->storeAs('/barang', $originalFileName , 'public');
        }
        $barang = new Barang;
        $barang->nama_barang = $nama;
        $barang->user_id = Auth::user()->id;
        $barang->harga = $harga;
        $barang->tanggal_pembelian = $request->tanggal_pembelian;
        $barang->foto = $path;
        $barang->save();

        Session::flash('success', 'Data berhasil disimpan!');
        return redirect('/barang');
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $data = Barang::where('id', $id)->first();
        return view('barang.edit', [
            'data' => $data,
            'title' => 'Edit Barang',
        ]);
    }

    public function update(Request $request, $id)
    {
        $foto = $request->file('foto');

        if ($foto != null) {
            $originalFileName = now()->timestamp."_".$foto->getClientOriginalName();
            $path = $request->file('foto')->storeAs('/barang', $originalFileName , 'public');
        }

        $barang = Barang::find($id);
        $barang->user_id = Auth::user()->id;
        $barang->nama_barang = $request-> nama_barang;
        $barang->harga = $request-> harga;
        $barang->tanggal_pembelian = $request->tanggal_pembelian;
        $barang->foto = $path;
        $barang->save();
        return redirect()->route('barang.index')->with('success','barang berhasil di update');
    }
    public function destroy($id)
    {
        $post = Barang::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('barang.index')
                ->with([
                    'success' => 'Data berhasil dihapus '
                ]);
        } else {
            return redirect()
                ->route('barang.index')
                ->with([
                    'error' => 'Terjadi kesalahan, silahkan coba lagi!'
                ]);
        }
    }
}
