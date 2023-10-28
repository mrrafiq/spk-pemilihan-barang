@extends('layout.main')
@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{url('/perhitungan/store')}}" method="POST">
            @csrf
            <h5>
                {{$title}}
            </h5>
            <div class="row mb-5 mt-2">
                <div class="col-md-4">
                    <label for="" class="form-label">Nama Perhitungan</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
            </div>
            <hr>
    </div>
    <div class="card-body">
            <div class="container text-center">
                <div class="row align-items-start my-3">
                    <div class="col">
                        <strong>Kriteria Pertama</strong>
                    </div>
                    <div class="col">
                        <strong>Perbandingan</strong>
                    </div>
                    <div class="col">
                        <strong>Kriteria Kedua</strong>
                    </div>
                </div>
                @for ($i = 0; $i < count($kriteria)-1; $i++)
                    <div class="row align-items-start my-3">
                        <div class="col">
                            @for ($j = $i+1; $j < count($kriteria); $j++)
                            <p>
                                {{$kriteria[$i]->nama_kriteria}}
                            </p><br>
                            @endfor
                        </div>
                        <div class="col">
                            @for ($j = $i+1; $j < count($kriteria); $j++)
                                <select class="form-select" name="{{strtolower(str_replace(' ', '_', $kriteria[$i]->nama_kriteria))}}[]" id="" required> {{-- name = Harga Barang[] -> name="harga_barang[]" --}}
                                    <option value="0.11"> 0.11</option>
                                    <option value="0.12"> 0.12</option>
                                    <option value="0.14"> 0.14</option>
                                    <option value="0.16"> 0.16</option>
                                    <option value="0.20"> 0.20</option>
                                    <option value="0.25"> 0.25</option>
                                    <option value="0.33"> 0.33</option>
                                    <option value="0.5"> 0.5</option>
                                    <option value="1" selected> 1</option>
                                    <option value="2"> 2</option>
                                    <option value="3"> 3</option>
                                    <option value="4"> 4</option>
                                    <option value="5"> 5</option>
                                    <option value="6"> 6</option>
                                    <option value="7"> 7</option>
                                    <option value="8"> 8</option>
                                    <option value="9"> 9</option>
                                </select><br>
                            @endfor
                        </div>
                        <div class="col">
                            @for ($j = $i+1; $j < count($kriteria); $j++)
                            <p>
                                {{$kriteria[$j]->nama_kriteria}}
                            </p>
                            <br>
                            @endfor
                        </div>
                    </div>
                @endfor
            </div>
            <div class="mb-3">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    @endsection
