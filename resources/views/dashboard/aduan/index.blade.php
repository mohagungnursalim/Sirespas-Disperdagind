@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Aduan Masuk
@endsection

@section('container')



<div class="card shadow mt-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <!-- Button trigger modal -->


    </div>
    <div class="card-body">

        <div class="container">




            <div class="d-flex justify-content-end">

                <form class="form-inline" action="/dashboard/aduan-masuk">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search..Aduan"
                        aria-label="Search">
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
                    <a class="btn btn-outline-primary" href="/dashboard/aduan-masuk">Refresh</a>
                </form>

                <form action="/export-aduan" method="get">
                    <button class="btn btn-outline-success">Export</button>
                </form>
            </div>
            <table id="myTable" class="table table-bordered text-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No.Hp/Wa</th>
                    <th>Lokasi Pasar</th>
                    <th>Lampiran Foto</th>
                    <th>Aduan</th>
                    <th>Tanggal</th>

                    @if (Auth::user()->is_admin == true)
                    @if (Auth::user()->operator == 'hanyalihat')

                    @else
                    <th>Aksi</th>
                    @endif

                    @else

                    @endif
                </tr>
                @foreach ($aduans as $aduan )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $aduan->nama }}</td>
                    <td>{{ $aduan->no_hp }}</td>
                    <td>{{ $aduan->pasar }}</td>
                    <td><img src="{{ asset('storage/' .$aduan->gambar) }}" class="img-thumbnail" data-toggle="modal"
                            data-target="#exampleModalimage{{ $aduan->id }}" alt="{{ $aduan->gambar }}" width="80px">
                    </td>
                    <td>{{ $aduan->isi_aduan }}</td>
                    <td>{{ Carbon\Carbon::parse($aduan->created_at)->format('d/m/Y') }}</td>

                    @if (Auth::user()->is_admin == true)
                    @if (Auth::user()->operator == 'hanyalihat')
                    @else
                    <td>

                        <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#exampleModalbalas{{ $aduan->id }}">
                        <i class="fas fa-fw fa-paper-plane"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#exampleModaldelete{{ $aduan->id }}">
                            <i class="fas fa-fw fa-trash"></i>
                        </button>
                    </td>
                    @endif
                    @else
                    @endif
                </tr>
                @endforeach

            </table>

            <div class="d-flex justify-content-center">
                {{ $aduans->links() }}
            </div>
        </div>



    </div>
</div>


@endsection









@foreach ($aduans as $aduan )
<!-- Modal Delete Data -->
<div class="modal fade" id="exampleModaldelete{{ $aduan->id }}" tabindex="-1" role="dialog"
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

                <form method="post" action="{{ route('aduan-pasar.destroy',$aduan->id) }}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus aduan <span
                            class="badge badge-danger">{{ $aduan->nama }}</span> ? </h2>
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

@foreach ($aduans as $aduan )
<!-- Modal show image -->
<div class="modal fade" id="exampleModalimage{{ $aduan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lampiran Foto <u>{{ $aduan->nama }}</u></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <img src="{{ asset('storage/' .$aduan->gambar) }}" class="img-thumbnail rounded mx-auto d-block"
                        data-toggle="modal" data-target="#exampleModalimage{{ $aduan->id }}" alt="{{ $aduan->gambar }}"
                        width="720px">

                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($aduans as $aduan )
<!-- Modal Balas Aduan -->
<div class="modal fade" id="exampleModalbalas{{ $aduan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Balas Aduan <u>{{ $aduan->nama }}</u></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="post" action="{{ route('send.whatsapp') }}" class="mb-2" 
                        enctype="multipart/form-data">
                        @csrf
                        <label>Nomor Tujuan</label>
                        <input type="text" value="{{$aduan->no_hp}}" class="form-control" readonly name="no_hp"><br>
                        <textarea placeholder="Masukan Balasan.." class="form-control" name="balasan" rows="7"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach
