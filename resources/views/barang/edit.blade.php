@extends('layout/main')
@section('content')
<div class="card">
    <h5 class="card-header">{{$title}}</h5>
    <div class="card-body">
      <form action="{{url('/barang/update/'.$data->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $data->nama_barang }}">
        </div>
        <div class="mb-3 ">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $data->harga }}">
        </div>
        <div class="mb-3 ">
          <label for="tanggal_pembelian" class="form-label">Tanggal-pembelian</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal_pembelian" value="{{ $data->tanggal_pembelian }}">
        </div>
        <div class="mb-3 ">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>
        {{-- Menampilkan foto yang telah diupload --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Terupload</label>
            <br>
            @if ($data->foto != null)
                <a href="{{asset('storage/'.$data->foto)}}" target="blank"><img src="{{asset('storage/'.$data->foto)}}" alt="" width="200px"></a>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
</div>
@endsection
