@extends('layout.main')
@section('content')
<h4>{{$title}}</h4>
<div class="card p-4">
  {{-- <h5 class="card-header">{{$title}}</h5> --}}
  <h5>Hasil Perhitungan AHP</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Kriteria</th>
          <th>Bobot</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @php
          $no = 1;
        @endphp
        @foreach ($ahp as $data)
          <tr>
            <td>{{$no++}}</td>
            <td>{{ucwords(str_replace("_"," ",$data->kriteria))}}</td>
            <td>{{$data->bobot}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card mt-4 p-4">
  {{-- <h5 class="card-header">{{$title}}</h5> --}}
  <h5>Hasil Perhitungan ARAS</h5>
  @if ($aras->isEmpty())
    <div class="row">
      <div class="col text-end me-5">
          <a href="{{url('/perhitungan/aras/create')}}" class="btn btn-warning">Mulai Perhitungan</a>
      </div>
    </div>
  @endif
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Nama Barang</th>
          <th>Utility Point</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @if ($aras->isEmpty())
          <tr>
            <td colspan="3" class="text-center">Perhitungan Belum Dilakukan!</td>
          </tr>
          
        @endif
        @foreach ($aras as $data)
          <tr>
            <td>{{$data->rank}}</td>
            <td>{{$data->barang->nama_barang}}</td>
            <td>{{$data->utility_point}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection