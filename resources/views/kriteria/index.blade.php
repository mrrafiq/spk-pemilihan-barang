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
                <a href="{{url('/kriteria/create')}}" class="btn btn-primary">Tambah</a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
            <thead>
                <tr>
                    <th>Nama Kriteria</th>
                    <th>Deskripsi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($datas as $data)
                <tr>
                    <td>{{$data->nama_kriteria}}</td>
                    <td>{{$data->deskripsi}}</td>
                    <td>
                        <a href="{{url('/kriteria/edit/'.$data->id)}}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{url('/kriteria/destroy/'.$data->id)}}" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="submit"
                            class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin?')">Delete</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection
