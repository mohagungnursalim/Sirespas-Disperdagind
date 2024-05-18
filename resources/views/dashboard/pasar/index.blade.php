@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Data Pasar Kota Palu
@endsection

@section('container')



<div class="card shadow mt-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <!-- Button trigger modal -->
    </div>
    <div class="card-body">

        @foreach ($errors->all() as $error )
        <li>{{ $error }}</li>
        @endforeach

        <div class="container">
            @if (auth()->user()->operator == 'hanyalihat')


            @else
            @can('admin')

            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Pasar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{$jumlahpasar}}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Bersertifikat</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{$sertifikatada}}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Tidak bersertifikat</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{$sertifikattidak}}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-dark shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                        Total Petugas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{$totalpetugas}}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                style="background-color: rgb(195, 0, 255); border:0ch" data-target=".bd-example-modal-lg">Tambah
                Pasar</button>
            @endcan
            @endif

            <div class="overflow-auto">
                <table id="myTable" class="table table-bordered  table-hover text-dark">
                    <thead class="thead-dark">

                        <tr class="text-center">
                            <th class="align-middle" rowspan="2">No</th>
                            <th class="align-middle" rowspan="2">Nama Pasar</th>
                            <th class="align-middle" rowspan="2">Foto</th>
                            <th class="align-middle" rowspan="2">Tahun Pembangunan</th>
                            <th class="align-middle" rowspan="2">Luas Lahan m²</th>
                            <th class="align-middle" colspan="2">Sertifikat</th>
                            <th class="align-middle" rowspan="2">Kecamatan</th>
                            <th class="align-middle" rowspan="2">Kelurahan</th>
                            <th class="align-middle" rowspan="2">Status Pasar</th>
                            <th class="align-middle" colspan="5">Jumlah</th>
                            <th class="align-middle" colspan="3">Kondisi Bangunan</th>
                            <th class="align-middle"
                                colspan="@if(auth()->user()->operator == 'hanyalihat') 4 @else 5 @endif">Jumlah Tenaga
                            </th>
                        </tr>

                        <tr class="text-center">
                            <th>ada</th>
                            <th>tidak</th>
                            <th>Pedagang</th>
                            <th>Kios Petak</th>
                            <th>Los Petak</th>
                            <th>Lapak/ Pelataran</th>
                            <th>Ruko</th>
                            <th>Baik</th>
                            <th>Rusak</th>
                            <th>Terpakai</th>
                            <th>Kepala Pasar [orang]</th>
                            <th>Kebersihan [orang]</th>
                            <th>Keamanan [orang]</th>
                            <th>Retribusi [orang]</th>
                            @if (auth()->user()->operator == 'hanyalihat')

                            @else
                            @can('admin')
                            <th>Aksi</th>
                            @endcan
                            @endif

                        </tr>

                    </thead>
                    @foreach ($pasars as $pasar)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pasar->nama }}</td>
                        <td><img src="{{ asset('storage/' .$pasar->image) }}" alt="{{ $pasar->nama }}" width="50px">
                        </td>
                        <td>{{ $pasar->tahun_pembangunan }}</td>
                        <td> {{ number_format($pasar->luas_lahan)  }}</td>
                        <td>
                            {{-- status ada --}}
                            @if ($pasar->sertifikat == 'Ada')
                            {{ $pasar->sertifikat }}
                            @else

                            @endif
                        </td>
                        <td>
                            {{-- status tidak --}}
                            @if ($pasar->sertifikat == 'Tidak')
                            {{ $pasar->sertifikat }}
                            @else

                            @endif
                        </td>
                        <td>{{ $pasar->kecamatan }}</td>
                        <td>{{ $pasar->kelurahan }}</td>
                        <td>{{ $pasar->status_pasar }}</td>
                        <td>{{ $pasar->pedagang }}</td>
                        <td>{{ $pasar->kios_petak }}</td>
                        <td>{{ $pasar->los_petak }}</td>
                        <td>{{ $pasar->lapak_pelataran }}</td>
                        <td>{{ $pasar->ruko }}</td>
                        <td>{{ $pasar->baik }}</td>
                        <td>{{ $pasar->rusak }}</td>
                        <td>{{ $pasar->terpakai }}</td>
                        <td>{{ $pasar->kepala_pasar }}</td>
                        <td>{{ $pasar->kebersihan }}</td>
                        <td>{{ $pasar->keamanan }}</td>
                        <td>{{ $pasar->retribusi }}</td>
                        @if (auth()->user()->operator == 'hanyalihat')

                        @else
                        @can('admin')
                        <td>
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#exampleModal{{ $pasar->id }}">
                                <i class="fas fa-fw fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#exampleModaldelete{{ $pasar->id }}">
                                <i class="fas fa-fw fa-trash"></i>
                            </button>
                        </td>
                        @endcan
                        @endif

                    </tr>

                    @endforeach
                    <tr class="text-center">
                        <th class="align-middle" colspan="4">Total</th>
                        <th class="align-middle"><small><b>{{ number_format($luas)  }} m<sup>2</sup></b></small></th>
                        <th class="align-middle">
                            <kbd class="bg-primary">{{ $sertifikatada }}</kbd>
                        </th>
                        <th class="align-middle">
                            <kbd class="bg-secondary">{{ $sertifikattidak }}</kbd>
                        </th>
                        <th class="align-middle"></th>
                        <th class="align-middle"></th>
                        <th class="align-middle"></th>
                        <th class="align-middle">
                            {{-- Total Pedagang --}}
                            <kbd class="bg-success">{{ $pedagang }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Kios Petak --}}
                            <kbd class="bg-success"> {{ $kios_petak }}</kbd>
                        </th>
                        <th class="align-middle">
                            <kbd class="bg-success">{{ $los_petak }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total lapak pelataran --}}
                            <kbd class="bg-success">{{ $lapak_pelataran }}</kbd>

                        </th>
                        <th class="align-middle">
                            {{-- Total Ruko --}}
                            <kbd class="bg-success">{{ $ruko }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total baik --}}
                            <kbd class="bg-success">{{ $baik }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Rusak --}}
                            <kbd class="bg-success">{{ $rusak }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Terpakai --}}
                            <kbd class="bg-success">{{ $terpakai }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Kapas --}}
                            <kbd class="bg-success">{{ $kepala_pasar }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Kebersihan --}}
                            <kbd class="bg-success">{{ $kebersihan }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Keamanan --}}
                            <kbd class="bg-success">{{ $keamanan }}</kbd>
                        </th>
                        <th class="align-middle">
                            {{-- Total Retribusi --}}
                            <kbd class="bg-success">{{ $retribusi }}</kbd>
                        </th>

                    </tr>
                </table>
            </div>

            {{-- {{ $pasars->links() }} --}}
        </div>



    </div>
</div>


@endsection

{{-- Input Data Pasar --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pasar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="modal-body">
                    <form action="/dashboard/pasar" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput">Nama Pasar</label>
                            <input type="text" class="form-control" name="nama" id="formGroupExampleInput"
                                placeholder="Masukan nama pasar..">
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Foto Pasar</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5" width="140px">
                            <input onchange="previewImage()" type="file" id="image" class="form-control" name="image"
                                id="formGroupExampleInput">
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Tahun Pembangunan</label>
                            <input type="text" class="form-control" name="tahun_pembangunan" id="formGroupExampleInput"
                                placeholder="Masukan tahun..">
                            @error('tahun_pembangunan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Luas Lahan (M<sup>2</sup>)</label>
                            <input type="text" class="form-control" name="luas_lahan" id="formGroupExampleInput"
                                placeholder="Masukan luas lahan..">
                            @error('luas_lahan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Sertifikat</label>
                            <select class="form-control" name="sertifikat" id="">
                                <option>--Sertifikat--</option>
                                <option value="Ada">Ada</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <select class="form-control" name="kecamatan" id="">
                                <option>--Kecamatan--</option>
                                <option value="Mantikulore">Mantikulore</option>
                                <option value="Palu Barat">Palu Barat</option>
                                <option value="Palu Selatan">Palu Selatan</option>
                                <option value="Palu Timur">Palu Timur</option>
                                <option value="Palu Utara">Palu Utara</option>
                                <option value="Tatanga">Tatanga</option>
                                <option value="Taweli">Taweli</option>
                                <option value="Ulujadi">Ulujadi</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kelurahan</label>
                            <select class="form-control" name="kelurahan" id="">
                                <option>--Kelurahan--</option>
                                <option value="Buluri">Buluri</option>
                                <option value="Donggala Kodi">Donggala Kodi</option>
                                <option value="Kabonena">Kabonena</option>
                                <option value="Silae">Silae</option>
                                <option value="Tipo">Tipo</option>
                                <option value="Watusampu">Watusampu</option>
                                <option value="Baiya">Baiya</option>
                                <option value="Lambara">Lambara</option>
                                <option value="Penawu">Panawu</option>
                                <option value="Pantaloan">Pantaloan</option>
                                <option value="Pantaloan Boya">Pantaloan Boya</option>
                                <option value="Boyaoge">Boyaonge</option>
                                <option value="Duyu">Duyu</option>
                                <option value="Nunu">Nunu</option>
                                <option value="Palupi">Palupi</option>
                                <option value="Pengawu">Pengawu</option>
                                <option value="Tawanjuka">Tawanjuka</option>
                                <option value="Kayumalue Ngapa">Kayumalue Ngapa</option>
                                <option value="Kayumalue Pajeko">Kayumalue Pajeko</option>
                                <option value="Mamboro">Mamboro</option>
                                <option value="Mamboro Barat">Mamboro Barat</option>
                                <option value="Taipa">Taipa</option>
                                <option value="Besusu Barat">Besusu Barat</option>
                                <option value="Besusu Tengah">Besusu Tengah</option>
                                <Option value="Besusu Timur">Besusu Timur</Option>
                                <option value="Lolu Selatan">Lolu Selatan</option>
                                <option value="Lolu Utara">Lolu Utara</option>
                                <option value="Birobuli Selatan">Birobuli Selatan</option>
                                <option value="Birobuli Utara">Birobuli Utara</option>
                                <option value="Petobo">Petobo</option>
                                <option value="Tatura Selatan">Tatura Selatan</option>
                                <option value="Tatura Utara">Tatura Utara</option>
                                <option value="Balaroa">Balaroa</option>
                                <option value="Baru">Baru</option>
                                <option value="Kamonji">Kamonji</option>
                                <option value="Lere">Lere</option>
                                <option value="Siranindi">Siranindi</option>
                                <option value="Ujuna">Ujuna</option>
                                <option value="Kawatuna">Kawatuna</option>
                                <option value="Lasoani">Lasoani</option>
                                <option value="Layana Indah">Layana Indah</option>
                                <option value="Poboya">Poboya</option>
                                <option value="Talise">Talise</option>
                                <option value="Talise Valangguni">Talise Valangguni</option>
                                <option value="Tanamodindi">Tanamodindi</option>
                                <option value="Tondo">Tondo</option>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Status Pasar</label>
                            <select class="form-control" name="status_pasar" id="">
                                <option>--Status--</option>
                                <option value="Harian">Harian</option>
                                <option value="Mingguan">Mingguan</option>
                            </select>
                        </div>
                        <hr>
                        <Kbd>JUMLAH</Kbd>
                        <hr>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Pedagang</label>
                            <input type="text" class="form-control" name="pedagang" id="formGroupExampleInput"
                                placeholder="Masukan jumlah pedagang..">
                            @error('pedagang')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Kios Petak</label>
                            <input type="text" class="form-control" name="kios_petak" id="formGroupExampleInput"
                                placeholder="Masukan jumlah kios petak..">
                            @error('kios_petak')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Los Petak</label>
                            <input type="text" class="form-control" name="los_petak" id="formGroupExampleInput"
                                placeholder="Masukan jumlah los petak..">
                            @error('los_petak')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Lapak Pelataran</label>
                            <input type="text" class="form-control" name="lapak_pelataran" id="formGroupExampleInput"
                                placeholder="Masukan jumlah lapak pelataran..">
                            @error('lapak_pelataran')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Ruko</label>
                            <input type="text" class="form-control" name="ruko" id="formGroupExampleInput"
                                placeholder="Masukan jumlah lapak ruko..">
                            @error('ruko')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <hr>
                        <KBd>KONDISI BANGUNAN</KBd>
                        <hr>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Baik</label>
                            <input type="text" class="form-control" name="baik" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('baik')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Rusak</label>
                            <input type="text" class="form-control" name="rusak" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('rusak')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Terpakai</label>
                            <input type="text" class="form-control" name="terpakai" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('terpakai')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <KBd>JUMLAH TENAGA</KBd>
                        <hr>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Kepala Pasar</label>
                            <input type="text" class="form-control" name="kepala_pasar" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('kepala_pasar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Kebersihan</label>
                            <input type="text" class="form-control" name="kebersihan" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('kebersihan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Keamanan</label>
                            <input type="text" class="form-control" name="keamanan" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('keamanan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Retribusi</label>
                            <input type="text" class="form-control" name="retribusi" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('retribusi')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
            </div>

            <div class="text-center mb-3">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
            </form>
        </div>
    </div>
</div>


@foreach ($pasars as $pasar )
<!-- Modal Edit Data -->
<div class="modal fade" id="exampleModal{{ $pasar->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update data {{ $pasar->nama }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post" action="{{ route('pasar.update',$pasar->id) }}" class="mb-5"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="formGroupExampleInput">Nama Pasar</label>
                            <input type="text" class="form-control" required value="{{ old('nama' ,$pasar->nama) }}"
                                name="nama" id="formGroupExampleInput" placeholder="Masukan nama pasar..">
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Foto Pasar</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5" width="140px">
                            <input onchange="previewImage()" type="file" id="image" class="form-control" name="image"
                                id="formGroupExampleInput">
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Tahun Pembangunan</label>
                            <input type="text" class="form-control"
                                value="{{ old('tahun_pembangunan' ,$pasar->tahun_pembangunan) }}" required
                                name="tahun_pembangunan" id="formGroupExampleInput" placeholder="Masukan tahun..">
                            @error('tahun_pembangunan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Luas Lahan (M<sup>2</sup>)</label>
                            <input type="text" class="form-control" value="{{ old('luas_lahan' ,$pasar->luas_lahan) }}"
                                name="luas_lahan" id="formGroupExampleInput" placeholder="Masukan luas lahan..">
                            @error('luas_lahan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Sertifikat</label>
                            <select class="form-control" name="sertifikat" id="">
                                <option value="{{ old('sertifikat' ,$pasar->sertifikat) }}">{{ $pasar->sertifikat }}
                                </option>

                                <option value="Ada">Ada</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <select class="form-control" name="kecamatan" id="">
                                <option value="{{ old('kecamatan' ,$pasar->kecamatan) }}">{{ $pasar->kecamatan }}
                                </option>
                                <option value="Mantikulore">Mantikulore</option>
                                <option value="Palu Barat">Palu Barat</option>
                                <option value="Palu Selatan">Palu Selatan</option>
                                <option value="Palu Timur">Palu Timur</option>
                                <option value="Palu Utara">Palu Utara</option>
                                <option value="Tatanga">Tatanga</option>
                                <option value="Taweli">Taweli</option>
                                <option value="Ulujadi">Ulujadi</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kelurahan</label>
                            <select class="form-control" name="kelurahan" id="">
                                <option value="{{ old('kelurahan' ,$pasar->kelurahan) }}">{{ $pasar->kelurahan }}
                                </option>
                                <option value="Buluri">Buluri</option>
                                <option value="Donggala Kodi">Donggala Kodi</option>
                                <option value="Kabonena">Kabonena</option>
                                <option value="Silae">Silae</option>
                                <option value="Tipo">Tipo</option>
                                <option value="Watusampu">Watusampu</option>
                                <option value="Baiya">Baiya</option>
                                <option value="Lambara">Lambara</option>
                                <option value="Penawu">Panawu</option>
                                <option value="Pantaloan">Pantaloan</option>
                                <option value="Pantaloan Boya">Pantaloan Boya</option>
                                <option value="Boyaoge">Boyaonge</option>
                                <option value="Duyu">Duyu</option>
                                <option value="Nunu">Nunu</option>
                                <option value="Palupi">Palupi</option>
                                <option value="Pengawu">Pengawu</option>
                                <option value="Tawanjuka">Tawanjuka</option>
                                <option value="Kayumalue Ngapa">Kayumalue Ngapa</option>
                                <option value="Kayumalue Pajeko">Kayumalue Pajeko</option>
                                <option value="Mamboro">Mamboro</option>
                                <option value="Mamboro Barat">Mamboro Barat</option>
                                <option value="Taipa">Taipa</option>
                                <option value="Besusu Barat">Besusu Barat</option>
                                <option value="Besusu Tengah">Besusu Tengah</option>
                                <Option value="Besusu Timur">Besusu Timur</Option>
                                <option value="Lolu Selatan">Lolu Selatan</option>
                                <option value="Lolu Utara">Lolu Utara</option>
                                <option value="Birobuli Selatan">Birobuli Selatan</option>
                                <option value="Birobuli Utara">Birobuli Utara</option>
                                <option value="Petobo">Petobo</option>
                                <option value="Tatura Selatan">Tatura Selatan</option>
                                <option value="Tatura Utara">Tatura Utara</option>
                                <option value="Balaroa">Balaroa</option>
                                <option value="Baru">Baru</option>
                                <option value="Kamonji">Kamonji</option>
                                <option value="Lere">Lere</option>
                                <option value="Siranindi">Siranindi</option>
                                <option value="Ujuna">Ujuna</option>
                                <option value="Kawatuna">Kawatuna</option>
                                <option value="Lasoani">Lasoani</option>
                                <option value="Layana Indah">Layana Indah</option>
                                <option value="Poboya">Poboya</option>
                                <option value="Talise">Talise</option>
                                <option value="Talise Valangguni">Talise Valangguni</option>
                                <option value="Tanamodindi">Tanamodindi</option>
                                <option value="Tondo">Tondo</option>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Status Pasar</label>
                            <select class="form-control" name="status_pasar" id="">
                                <option value="{{ old('status_pasar' ,$pasar->status_pasar) }}">
                                    {{ $pasar->status_pasar }}</option>
                                <option value="Harian">Harian</option>
                                <option value="Mingguan">Mingguan</option>
                            </select>
                        </div>
                        <hr>
                        <Kbd>JUMLAH</Kbd>
                        <hr>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Pedagang</label>
                            <input type="text" value="{{ old('pedaganga' ,$pasar->pedagang) }}" class="form-control"
                                name="pedagang" id="formGroupExampleInput" placeholder="Masukan jumlah pedagang..">
                            @error('pedagang')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Kios Petak</label>
                            <input type="text" class="form-control" value="{{ old('kios_petak' ,$pasar->kios_petak) }}"
                                name="kios_petak" id="formGroupExampleInput" placeholder="Masukan jumlah kios petak..">
                            @error('kios_petak')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Los Petak</label>
                            <input type="text" class="form-control" value="{{ old('los_petak' ,$pasar->los_petak) }}"
                                name="los_petak" id="formGroupExampleInput" placeholder="Masukan jumlah los petak..">
                            @error('los_petak')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Lapak Pelataran</label>
                            <input type="text" class="form-control"
                                value="{{ old('lapak_pelataran' ,$pasar->lapak_pelataran) }}" name="lapak_pelataran"
                                id="formGroupExampleInput" placeholder="Masukan jumlah lapak pelataran..">
                            @error('lapak_pelataran')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Jumlah Ruko</label>
                            <input type="text" class="form-control" value="{{ old('ruko' ,$pasar->ruko) }}" name="ruko"
                                id="formGroupExampleInput" placeholder="Masukan jumlah lapak ruko..">
                            @error('ruko')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <hr>
                        <KBd>KONDISI BANGUNAN</KBd>
                        <hr>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Baik</label>
                            <input type="text" value="{{ old('baik' ,$pasar->baik) }}" class="form-control" name="baik"
                                id="formGroupExampleInput" placeholder="Jumlah..">
                            @error('baik')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Rusak</label>
                            <input type="text" value="{{ old('rusak' ,$pasar->rusak) }}" class="form-control"
                                name="rusak" id="formGroupExampleInput" placeholder="Jumlah..">
                            @error('rusak')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Terpakai</label>
                            <input type="text" value="{{ old('terpakai' ,$pasar->terpakai) }}" class="form-control"
                                name="terpakai" id="formGroupExampleInput" placeholder="Jumlah..">
                            @error('terpakai')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <KBd>JUMLAH TENAGA</KBd>
                        <hr>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Kepala Pasar</label>
                            <input type="text" value="{{ old('kepala_pasar' ,$pasar->kepala_pasar) }}"
                                class="form-control" name="kepala_pasar" id="formGroupExampleInput"
                                placeholder="Jumlah..">
                            @error('kepala_pasar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Kebersihan</label>
                            <input type="text" value="{{ old('kebersihan' ,$pasar->kebersihan) }}" class="form-control"
                                name="kebersihan" id="formGroupExampleInput" placeholder="Jumlah..">
                            @error('kebersihan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Keamanan</label>
                            <input type="text" value="{{ old('keamanan' ,$pasar->keamanan) }}" class="form-control"
                                name="keamanan" id="formGroupExampleInput" placeholder="Jumlah..">
                            @error('keamanan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Retribusi</label>
                            <input type="text" value="{{ old('retribusi' ,$pasar->retribusi) }}" class="form-control"
                                name="retribusi" id="formGroupExampleInput" placeholder="Jumlah..">
                            @error('retribusi')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach



@foreach ($pasars as $pasar )
<!-- Modal Delete Data -->
<div class="modal fade" id="exampleModaldelete{{ $pasar->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('pasar.destroy',$pasar->id) }}}}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus <span
                            class="badge badge-danger">{{ $pasar->nama }}</span> ?? </h2>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
    integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

<!-- Tambahkan kode jQuery untuk membuka modal -->
@if ($errors->any())
<script>
    $(document).ready(function () {
        $('#inputModal').modal('show');
    });

</script>
@endif

<script>
    function previewImage() {

        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();

        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function (oFREvent) {

            imgPreview.src = oFREvent.target.result;

        }
    }
</script>
