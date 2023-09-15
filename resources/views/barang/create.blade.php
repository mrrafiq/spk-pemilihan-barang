@extends('layout.main')
@section('content')
<div class="card">
    <h5 class="card-header">{{$title}}</h5>
    <div class="card-body">
      <form action="{{url('/barang/store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
        </div>
        <div class="mb-3 ">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga">
        </div>
        <div class="mb-3 ">
          <label for="tanggal_pembelian" class="form-label">Tanggal-pembelian</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal_pembelian">
      </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    @endsection
            