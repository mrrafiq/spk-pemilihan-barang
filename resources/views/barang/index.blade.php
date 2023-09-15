@extends('layout.main')
@section('content')
  <div class="card">
                <h5 class="card-header">{{$title}}</h5>
                <div class="row">
                    <div class="col text-end me-5">
                        <a href="{{url('/barang/create')}}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Tanggal_pembelian</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($datas as $data)
                        <tr>
                            <td>{{$data->nama_barang}}</td>
                            <td>{{$data->harga}}</td>
                            <td>{{$data->tanggal_pembelian}}</td>
                            <td>
                                <a href="{{url('/barang/edit/'.$data->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{url('/barang/destroy/'.$data->id)}}">
                                  @method('delete')
                                  @csrf
                                  {{-- <a href="{{url('/barang/destroy/'.$data->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin?')">Delete</a> --}}
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