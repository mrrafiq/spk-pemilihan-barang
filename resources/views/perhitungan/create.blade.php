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
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kondisi Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kondisi[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Harga/nilai Barang
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kondisi Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kondisi[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Orang Lain
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kondisi Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kondisi[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Waktu Pemakaian
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kondisi Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kondisi[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Ruang Penyimpanan
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kondisi Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kondisi[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Finansial
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Harga/nilai Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="harga[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Orang Lain
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Nilai/Harga Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="harga[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Waktu Pemakaian
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Harga/Nilai Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="harga[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Ruang Penyimpanan
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Harga/Nilai Barang
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="harga[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Finansial
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kebutuhan Orang Lain
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kebutuhan_orang_lain[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Waktu Pemakaian
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kebutuhan Orang Lain
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kebutuhan_orang_lain[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Ruang Penyimpanan
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Kebutuhan Orang Lain
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="kebutuhan_orang_lain[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Finansial
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Waktu Pemakaian
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="waktu_pemakaian[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Ruang Penyimpanan
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Waktu Pemakaian
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="waktu_pemakaian[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Finansial
                    </div>
                </div>
                <div class="row align-items-start my-3">
                    <div class="col">
                        Ruang Penyimpanan
                    </div>
                    <div class="col mx-3">
                        <select class="form-select form-select-sm" name="ruang_penyimpanan[]" id="">
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                            <option value="5"> 5</option>
                            <option value="6"> 6</option>
                            <option value="7"> 7</option>
                            <option value="8"> 8</option>
                            <option value="9"> 9</option>
                        </select>

                    </div>
                    <div class="col">
                        Kebutuhan Finansial
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    @endsection