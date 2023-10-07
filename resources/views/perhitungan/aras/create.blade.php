@extends('layout.main')
@section('content')
@if ($barang->isEmpty())
  <h5>Data Barang Belum Ada!</h5>
@else
<form action="{{url('/perhitungan/aras/store/'.$id)}}" method="POST">
@csrf
<div class="row mb-3">
    <div class="card border-warning ">
        <div class="card-body">
          <h5 class="card-title">Informasi</h5>
          <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores quisquam corporis quis, ipsum beatae amet, exercitationem ab, sit ratione itaque et saepe placeat quam excepturi voluptatibus omnis doloremque repellat velit!</p>
        </div>
    </div>
</div>
<div class="row">
@foreach ($barang as $key => $barang)
  <div class="col-md-6 mb-3">
    <div class="card">
      <div class="card-header">
        <h3>{{$barang->nama_barang}}</h3>
        <p>Harga: {{$barang->harga}}</p>
        <p>Tanggal Pembelian: {{$barang->tanggal_pembelian}}</p>
      </div>
      <div class="card-body">
        @foreach ($kriteria as $data_kriteria)
          <div class="row mb-3">
            <div class="col-md-5">
              <label for="" class="form-label">{{str_replace("_", " ", $data_kriteria)}}</label>
            </div>
            <div class="col-md-2">
              <input type="number" class="form-control" name="{{$data_kriteria}}[{{$key}}]" min="1" max="10">
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endforeach
</div>
<div class="row mb-3">
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
</form>
@endif
@endsection
