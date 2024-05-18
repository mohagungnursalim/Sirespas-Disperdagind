@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Kelola Akun
@endsection

@section('container')

<head>
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
        integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
</head>


<div class="card shadow mt-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <!-- Button trigger modal -->


    </div>
    <div class="container">
        <div class="card-body">
            <div class="alert alert-primary text-nowrap" style="width: 18rem;" role="alert">
                <i class="fas fa-fw fa-info-circle"></i> Password bawaan: 12345678
            </div>

            <form class="form-inline" action="{{ route('buat-akun.store') }}" method="post">
                @csrf
                <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only">Email</label>
                    <input type="text" required name="email" class="form-control" id="staticEmail2"
                        placeholder="email@example.com">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="" class="sr-only">Nama</label>
                    <input type="Nama.." required class="form-control" name="name" id="inputNama..2"
                        placeholder="Nama..">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select id="inputState" required name="operator" class="form-control">
                        <option selected>-Operator-</option>

                        <option value="hanyalihat" class="text-success">Hanya Lihat</option>
                        @foreach ($pasars as $pasar )
                        <option>{{ $pasar->nama }}</option>
                        @endforeach
                        <div class="dropdown-divider"></div>
                    </select>

                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select id="inputState" required name="is_admin" class="form-control">
                        <option selected>-Role-</option>

                        <option value="1" class="text-primary">Admin</option>
                        <option value="0" class="text-danger">Operator Pasar</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary mb-2">Buat</button>
            </form>
        </div>
    </div>
</div>
{{-- Card Table --}}
<div class="card shadow mt-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <!-- Button trigger modal -->


    </div>
    <div class="card-body">



        <div class="container">

            <form class="form-inline" action="/dashboard/buat-akun">
                <input class="form-control mr-sm-2" type="search" value="{{request('search')}}" name="search" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            
            <div class="overflow-auto">
                <table id="myTable" class="table table-bordered text-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama User</th>
                        <th>Operator</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>

                    </tr>

                    @if ($users->count())
                    @foreach ($users as $user )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user->operator == 'hanyalihat')
                            <kbd class="bg-secondary">{{ $user->operator }}</kbd>
                            @else
                            {{ $user->operator }}
                            @endif
                        </td>
                        <td>
                            @if ($user->is_admin == true)
                            <kbd class="bg-primary">Admin</kbd>
                            @elseif ($user->is_admin == false)
                            <kbd class="bg-success">Operator</kbd>
                            @endif

                        </td>
                        <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-m,Y') }}</td>

                        <td>
                            {{-- <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#exampleModal{{ $user->id }}">
                                <i class="fas fa-fw fa-edit"></i>
                            </button> --}}
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#exampleModaldelete{{ $user->id }}">
                            <i class="fas fa-fw fa-trash"></i>
                            </button>
                            {{-- <a href="/dashboard/komoditas/{{ $k->id }}/edit" class="btn btn-warning"><i
                                class="fas fa-fw fa-edit"></i></a>
                            --}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">
                                Tidak ada user 
                                @if (request('search'))
                                <kbd>{{ request('search') }}</kbd>                
                                @endif
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>



        </div>




    </div>

</div>



{{-- Modal Edit Data User --}}
@foreach ($users as $user )
<div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data [ {{ $user->name }} ]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('buat-akun.update',$user->id) }}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="formGroupExampleInput">Satuan</label>
                        <input type="text" required class="form-control" value="{{ old('nama' ,$user->nama) }}"
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


@foreach ($users as $user )
<!-- Modal Delete akun-->
<div class="modal fade" id="exampleModaldelete{{ $user->id }}" tabindex="-1" role="dialog"
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

                <form method="post" action="{{ route('buat-akun.destroy',$user->id) }}}}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus <span
                            class="badge badge-danger">{{ $user->name }}</span> ?? </h2>
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
@endsection
