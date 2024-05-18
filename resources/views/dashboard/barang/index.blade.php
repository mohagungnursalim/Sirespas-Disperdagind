@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Barang
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
                Tambah Barang
            </button>
            @endif
            
            <form class="form-inline" action="/dashboard/barang">
                <input class="form-control mr-sm-2" value="{{request('search')}}" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            <table id="myTable" class="table table-bordered text-dark">
                <tr>
                    <th>No</th>
                    <th>Jenis Barang</th>
                    <th>Komoditas</th>
                    <th>Gambar</th>
                    <th>Dibuat</th>
                    @if (auth()->user()->operator == 'hanyalihat')

                    @else
                    <th>Aksi</th>
                    @endif
                    

                </tr>

                @php
                    $startIteration = ($barangs->currentPage() - 1) * $barangs->perPage() + 1;
                @endphp
                @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration + $startIteration - 1 }}</td>
                        <td>{{ $barang->nama }}</td>
                        <td>{{ $barang->komoditas->nama }}</td> <!-- Menambahkan nama komoditas -->
                        <td><img src="{{ asset('storage/' . $barang->image) }}" alt="{{ $barang->nama }}" width="50px"></td>
                        <td>{{ Carbon\Carbon::parse($barang->created_at)->format('d/m/Y') }}</td>
                        @if (auth()->user()->operator != 'hanyalihat')
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#exampleModal{{ $barang->id }}">
                                    <i class="fas fa-fw fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModaldelete{{ $barang->id }}">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach

            </table>

            <div class="d-flex justify-content-center">
                {{ $barangs->links() }}
            </div>
        </div>



    </div>
</div>


@endsection





<!-- Modal Tambah Data Barang -->
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
                <form action="/dashboard/barang" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nama Barang</label>
                        <input type="text" class="form-control" name="nama" id="formGroupExampleInput"
                            placeholder="Masukan nama barang.." value="{{ old('nama') }}">
                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="komoditas_id">
                            <option>-Pilih Komoditas-</option>
                            @foreach ($selectkmd as $kmd)
                            <option value="{{$kmd->id}}"> {{$kmd->nama}}</option>
                            @endforeach
                           
                        </select>
                        @error('komoditas_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Gambar</label>
                        <img  class="img-preview img-fluid mb-3 col-sm-5" width="140px">
                        <input onchange="previewImage()" id="image" type="file" value="{{ old('image') }}" class="form-control" name="image" id="formGroupExampleInput">
                        @error('image')
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


@foreach ($barangs as $barang)
<!-- Modal Edit Data barang -->
<div class="modal fade" id="exampleModal{{ $barang->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('barang.update',$barang->id) }}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="formGroupExampleInput">Barang</label>
                        <input type="text" required class="form-control" value="{{ old('nama' ,$barang->nama) }}" name="nama"
                            id="formGroupExampleInput">

                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Komoditas</label>
                        <select required class="form-control text-success" name="komoditas_id">
                            <option>---------------------Pilih Komoditas---------------------</option>
                            <option selected value="{{ $barang->komoditas->id }}">{{ $barang->komoditas->nama }}
                            @foreach ($selectkmd as $kmdts)

                            <option value="{{ old('komoditas_id' ,$kmdts->id) }}" @selected(old('komoditas_id')==$kmdts->id)>
                                {{ $kmdts->nama }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editimage">Gambar</label>
                        @if($barang->image)
                        <img src="{{ asset('storage/' .$barang->image) }}"
                            class="img-preview img-fluid mb-3 col-sm-5 d-block" id="edit-preview">
                        @else
                        <img src="#" class="img-preview img-fluid mb-3 col-sm-5 d-none" id="edit-preview">
                        @endif
                        <input onchange="editImage()" id="editimage" type="file" class="form-control" name="image"
                            accept="image/*">

                        @error('image')
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



@foreach ($barangs as $barang )
<!-- Modal Delete Data -->
<div class="modal fade" id="exampleModaldelete{{ $barang->id }}" tabindex="-1" role="dialog"
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

                <form method="post" action="{{ route('barang.destroy',$barang->id) }}}}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus <span
                            class="badge badge-danger">{{ $barang->nama }}</span> ?? </h2>
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

{{-- input image preciew --}}
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

{{-- edit image preview --}}
<script>
    function editImage() {
        const image = document.querySelector('#editimage');
        const editPreview = document.querySelector('#edit-preview');

        const file = image.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            editPreview.src = e.target.result;
            editPreview.classList.remove('d-none'); // Tampilkan gambar preview
        }

        reader.readAsDataURL(file);
    }

</script>