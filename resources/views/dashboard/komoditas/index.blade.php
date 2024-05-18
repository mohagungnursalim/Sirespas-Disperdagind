@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Komoditas
@endsection

@section('container')



<div class="card shadow mt-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <!-- Button trigger modal -->


    </div>
    <div class="card-body">

        <div class="container">
            @if (auth()->user()->operator == 'hanyalihat')

            @else
            <button type="button" class="btn btn-primary mb-3" style="background-color: rgb(195, 0, 255); border:0ch"
                data-toggle="modal" data-target="#inputModal">
                Tambah komoditas
            </button>
            @endif

            <form class="form-inline" action="/dashboard/komoditas">
                <input class="form-control mr-sm-2" value="{{request('search')}}" type="search" name="search"
                    placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <table id="myTable" class="table table-bordered text-dark">
                <tr>
                    <th>No</th>
                    <th>Komoditas</th>
                    <th>Dibuat</th>
                    @if (auth()->user()->operator == 'hanyalihat')

                    @else
                    <th>Aksi</th>
                    @endif


                </tr>
                @php
                        $startIteration = ($komoditas->currentPage() - 1) * $komoditas->perPage() + 1;
                @endphp
                @foreach ($komoditas as $k )
                <tr>
                    <td>{{ $loop->iteration + $startIteration - 1 }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</td>

                    @if (auth()->user()->operator == 'hanyalihat')

                    @else
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#exampleModal{{ $k->id }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#exampleModaldelete{{ $k->id }}">
                            <i class="fas fa-fw fa-trash"></i>
                        </button>
                        {{-- <a href="/dashboard/komoditas/{{ $k->id }}/edit" class="btn btn-warning"><i
                            class="fas fa-fw fa-edit"></i></a>
                        --}}
                    </td>
                    @endif

                </tr>
                @endforeach

            </table>

            <div class="d-flex justify-content-center">
                {{ $komoditas->links() }}
            </div>
        </div>



    </div>
</div>


@endsection





<!-- Modal Tambah Data -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/dashboard/komoditas" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="formGroupExampleInput">Komoditas</label>
                        <input type="text" class="form-control" name="nama" id="formGroupExampleInput"
                            placeholder="Masukan nama komoditas.." value="{{ old('nama') }}">
                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>


@foreach ($komoditas as $kmd )
<!-- Modal Edit Data -->
<div class="modal fade" id="exampleModal{{ $kmd->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('komoditas.update',$kmd->id) }}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="formGroupExampleInput">Komoditas</label>
                        <input type="text" required class="form-control" value="{{ old('nama' ,$kmd->nama) }}"
                            name="nama" id="formGroupExampleInput" placeholder="Masukan Data..">

                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
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



@foreach ($komoditas as $kmd )
<!-- Modal Delete Data -->
<div class="modal fade" id="exampleModaldelete{{ $kmd->id }}" tabindex="-1" role="dialog"
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

                <form method="post" action="{{ route('komoditas.destroy',$kmd->id) }}}}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus <span
                            class="badge badge-danger">{{ $kmd->nama }}</span> ?? </h2>
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


