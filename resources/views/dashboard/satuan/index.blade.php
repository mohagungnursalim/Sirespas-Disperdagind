@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Satuan
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
            <button type="button" class="btn btn-primary mb-3" style="background-color: rgb(195, 0, 255); border:0ch" data-toggle="modal" data-target="#inputModal">
                Tambah Satuan
            </button>
            @endif
           
            <form class="form-inline" action="/dashboard/satuan">
                <input class="form-control mr-sm-2" type="search" value="{{request('search')}}" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
              <div class="overflow-auto">
            <table id="myTable" class="table table-bordered text-dark">
                <tr>
                    <th>No</th>
                    <th>Satuan</th>
                    <th>Dibuat</th>
                    @if (auth()->user()->operator == 'hanyalihat')
                        
                    @else
                    <th>Aksi</th>
                    @endif
                    
                    
                </tr>
                @foreach ($satuans as $satuan )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $satuan->nama }}</td>
                    <td>{{ Carbon\Carbon::parse($satuan->created_at)->format('d-m,Y') }}</td>

                    @if (auth()->user()->operator == 'hanyalihat')
                        
                    @else
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#exampleModal{{ $satuan->id }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#exampleModaldelete{{ $satuan->id }}">
                            <i class="fas fa-fw fa-trash"></i>
                        </button>
                        
                    </td>
                    @endif
                </tr>
                @endforeach
                
            </table>
              </div>
          {{ $satuans->links() }}
            
           
            
        </div>


        

    </div>
    
</div>


@endsection





<!-- Modal Tambah Data -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/dashboard/satuan" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="formGroupExampleInput">Satuan</label>
                        <input type="text" class="form-control" name="nama" id="formGroupExampleInput"
                            placeholder="Masukan satuan..">
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


@foreach ($satuans as $satuan )
<!-- Modal Edit Data -->
<div class="modal fade" id="exampleModal{{ $satuan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('satuan.update',$satuan->id) }}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="formGroupExampleInput">Satuan</label>
                        <input type="text" required class="form-control" value="{{ old('nama' ,$satuan->nama) }}" name="nama"
                            id="formGroupExampleInput" placeholder="Masukan Data..">

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



@foreach ($satuans as $satuan )
<!-- Modal Delete Data -->
<div class="modal fade" id="exampleModaldelete{{ $satuan->id }}" tabindex="-1" role="dialog"
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

                <form method="post" action="{{ route('satuan.destroy',$satuan->id) }}}}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus <span
                            class="badge badge-danger">{{ $satuan->nama }}</span> ?? </h2>
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
        $(document).ready(function() {
            $('#inputModal').modal('show');
        });
    </script>
@endif


