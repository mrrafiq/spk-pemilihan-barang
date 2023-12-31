@extends('layout.main')
@section('content')
  <div class="card">
    <h5 class="card-header">{{$title}}</h5>
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
      <div class="col text-end me-5">
          <a href="{{url('/perhitungan/create')}}" class="btn btn-primary">Tambah</a>
      </div>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Sesi</th>
            <th>Tanggal</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if (count($datas) == 0)
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>

            @endif
        <?php $no = 0?>
          @foreach ($datas as $data)
            <?php $no++?>
            <tr>
              <td>{{$no}}</td>
              <td>{{$data->name}}</td>
              <td>{{$data->created_at}}</td>
              <td>
                <a href="{{url('/perhitungan/detail/'.$data->id)}}" class="btn btn-sm btn-warning">Detail</a>
                {{-- <form action="{{url('/perhitungan/destroy/'.$data->id)}}">
                  @method('delete')
                  @csrf --}}
                  {{-- <a href="{{url('/barang/destroy/'.$data->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin?')">Delete</a> --}}
                  {{-- <button type="submit"
                  class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin?')">Delete</button>
                </form> --}}
            </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
