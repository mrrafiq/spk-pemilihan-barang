@extends('layout/main')
@section('content')
    <div>
        <p class="text-4xl">Edit</p>
    </div>
    <div class="mt-12">
        <form action="{{url('/barang/update/'.$data->id)}}" method="POST">
            {{ csrf_field() }}

            <div class="col-xs-12 col-sm-12 col-md-12"> 
                <div class="form-group">
                    <strong>Nama Barang:</strong>
                    <input type="text" name="nama_barang" value="{{ $data->nama_barang }}" class="form-control" placeholder="Harga">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Harga:</strong>
                    <input type="text" name="harga" value="{{ $data->harga }}" class="form-control" placeholder="Harga">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tanggal_pembelian:</strong>
                    <input type="date" name="tanggal_pembelian" value="{{ $data->tanggal }}" class="form-control" >
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-aligm">
            <button type="submit" class="btn btn-primary">EDIT</button>
            </div>
        </div>
        </div>
        </div>
        </div>
</form>
@endsection  
   