@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Retribusi
@endsection

@section('container')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>


<div class="card shadow mt-4">
    <div class="card-body">

        <div class="container">

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (auth()->user()->operator == 'hanyalihat')

            @else
            <a class="btn btn-primary mb-4" style="background-color: rgb(195, 0, 255); border:0ch" data-toggle="modal"
                data-target=".bd-example-modal-lg">+ Input Data</a>
            @endif

            <div class="input-group mb-2">

                <button class="btn btn-outline-dark" data-toggle="modal" data-target=".modal-filter">
                    <i class="fas fa-filter fa-sm"></i> Filter
                </button>
                </form>
                &nbsp;
                <button class="btn btn-outline-success" data-toggle="modal" data-target=".modal-export"><i
                        class="fas fa-file-excel"></i> Export
                </button>
                &nbsp;
                <a href="/dashboard/retribusi" class="btn btn-outline-primary"><i class="fas fa-refresh"></i> Refresh
                </a>
            </div>
        </div>

        @if (request('search'))
        <div class="container mt-4 mb-4">
            <a class="text-decoration-none text-dark">Filter Data: <kbd> "{{ request('search') }}"</kbd></a>
        </div>
        @endif

        @if (request('searchdate'))
        <div class="container mt-4 mb-4">
            <a class="text-decoration-none text-dark">Filter Tanggal: <kbd> "{{ request('searchdate') }}"</kbd></a>
        </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="overflow-auto">
                        <div class="d-flex flex-nowrap">
                            <!-- Content here -->

                            <table id="myTable" class="table table-bordered text-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pasar</th>
                                    <th>Nama Pedagang</th>
                                    <th>Alamat</th>
                                    <th>Jenis Retribusi</th>
                                    <th>Jumlah</th>
                                    <th>Metode Pembayaran</th>
                                    <th>No Pembayaran</th>
                                    <th>Keterangan</th>
                                    <th>Petugas Penerima</th>
                                    @if (auth()->user()->operator == 'hanyalihat')

                                    @else
                                    <th>Aksi</th>
                                    @endif
                                </tr>

                                @foreach ($retribusis as $retribusi )
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon\Carbon::parse($retribusi->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ optional($retribusi->pasar)->nama }}</td>
                                    <td>{{ $retribusi->nama_pedagang }}</td>
                                    <td>{{ $retribusi->alamat }}</td>
                                    <td>{{ $retribusi->jenis_retribusi }}</td>
                                    <td>Rp{{ number_format($retribusi->jumlah_pembayaran) }}</td>
                                    <td>{{ $retribusi->metode_pembayaran }}</td>
                                    <td>{{ $retribusi->no_pembayaran }}</td>
                                    <td>{{ $retribusi->keterangan }}</td>
                                    <td>{{ optional($retribusi->user)->name }}</td>


                                    @if (auth()->user()->operator == 'hanyalihat')

                                    @else
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editModal{{ $retribusi->id }}">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal{{ $retribusi->id }}">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    </td>
                                    @endif

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="d-flex justify-content-center">
            {{-- {{ $pangans->links() }} --}}
        </div>
    </div>

</div>

<!-- Modal Input Data -->
<div class="modal fade bd-example-modal-lg" id="inputModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card  shadow mt-4">
                <div class="modal-header">
                    <h5 class="modal-title text-dark text-center" id="exampleModalLabel">INPUT DATA RETRIBUSI PASAR 
                        @if (isset(Auth::user()->operator)) {{ Auth::user()->operator }} @endif <kbd
                            class="bg-primary"> @php echo date('Y') @endphp</kbd></h5>

                </div>
                <div class="container">
                    <div class="card-body">

                        <form method="post" action="{{ route('retribusi.store') }}" class="text-dark">
                            @csrf
                            
                            @if (Auth::user()->is_admin == true)
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pasar</label>
                                <select required class="form-control" name="pasar_id">
                                    <option value="">-Pilih pasar-</option>
                                    @foreach ($pasars as $pasar)
                                    <option value="{{ $pasar->id }}" @selected(old('pasar_id')==$pasar->id)>
                                        {{ $pasar->nama }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('pasar_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @else
                            <input type="hidden" name="pasar_id" id="" value="{{ Auth::user()->pasar_id }}">
                            @endif
                            <input type="hidden" name="user_id" id="" value="{{ Auth::user()->id }}">
                            <div class="form-group">
                                <label for="">Nama Pedagang</label>
                                <input required type="text" value="{{ old('nama_pedagang') }}" name="nama_pedagang"
                                    class="form-control">

                                @error('nama_pedagang')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input required type="text" value="{{ old('alamat') }}" name="alamat"
                                    class="form-control">

                                @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_retribusi">Jenis Retribusi</label>
                                <select required class="form-control" name="jenis_retribusi" id="jenis_retribusi">
                                    <option>-Pilih jenis retribusi-</option>
                                    <option value="Parkir" @selected(old('jenis_retribusi')=='Parkir' )>Parkir</option>
                                    <option value="Kebersihan" @selected(old('jenis_retribusi')=='Kebersihan' )>
                                        Kebersihan</option>
                                    <option value="Izin Usaha" @selected(old('jenis_retribusi')=='Izin Usaha' )>Izin
                                        Usaha</option>
                                    <option value="Pengelolaan Air" @selected(old('jenis_retribusi')=='Pengelolaan Air'
                                        )>Pengelolaan Air</option>
                                    <option value="Penggunaan Jalan"
                                        @selected(old('jenis_retribusi')=='Penggunaan Jalan' )>Penggunaan Jalan</option>
                                    <option value="Sampah" @selected(old('jenis_retribusi')=='Sampah' )>Sampah</option>
                                    <option value="Keamanan" @selected(old('jenis_retribusi')=='Keamanan' )>Keamanan
                                    </option>
                                    <option value="Perizinan Bangunan"
                                        @selected(old('jenis_retribusi')=='Perizinan Bangunan' )>Perizinan Bangunan
                                    </option>
                                    <option value="Peenggunaan Fasilitas Umum"
                                        @selected(old('jenis_retribusi')=='Peenggunaan Fasilitas Umum' )>Penggunaan
                                        Fasilitas Umum</option>
                                </select>

                                @error('jenis_retribusi')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Jumlah</label>
                                <input required type="number" value="{{ old('jumlah_pembayaran') }}"
                                    name="jumlah_pembayaran" class="form-control">

                                @error('jumlah_pembayaran')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <select required class="form-control" name="metode_pembayaran" id="metode_pembayaran">
                                    <option>-Pilih metode pembayaran-</option>
                                    <option value="Tunai" @selected(old('metode_pembayaran')=='Tunai' )>Tunai</option>
                                    <option value="Transfer Bank" @selected(old('metode_pembayaran')=='Transfer Bank' )>
                                        Transfer Bank</option>
                                    <option value="Kartu Kredit" @selected(old('metode_pembayaran')=='Kartu Kredit' )>
                                        Kartu Kredit</option>
                                    <option value="Kartu Debit" @selected(old('metode_pembayaran')=='Kartu Debit' )>
                                        Kartu Debit</option>
                                    <option value="E Wallet" @selected(old('metode_pembayaran')=='E Wallet' )>E-Wallet
                                    </option>
                                </select>

                                @error('metode_pembayaran')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <select required class="form-control" name="keterangan" id="keterangan">
                                    <option>-Pilih keterangan-</option>
                                    <option value="Lunas" @selected(old('keterangan')=='Lunas' )>Lunas</option>
                                    <option value="Belum Lunas" @selected(old('keterangan')=='Belum Lunas' )>Belum Lunas
                                    </option>
                                </select>

                                @error('keterangan')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Upload</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>

                        </form>





                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
@foreach ($retribusis as $retribusi)
<div class="modal fade bd-example-modal-lg" id="editModal{{ $retribusi->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card shadow mt-4">
                <div class="modal-header">
                    <h5 class="modal-title text-dark text-center" id="editModalLabel">EDIT DATA RETRIBUSI PASAR <kbd
                            class="bg-primary"> @php echo date('Y') @endphp</kbd></h5>
                </div>
                <div class="container">
                    <div class="card-body">
                        <form method="post" action="{{ route('retribusi.update', $retribusi->id) }}" class="text-dark">

                            @csrf
                            @method('put')

                            @if (Auth::user()->is_admin == true)             
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Pasar</label>
                                <select required class="form-control" name="pasar_id">
                                    <option value="">-Pilih pasar-</option>
                                    @foreach ($pasars as $pasar)
                                    <option value="{{ $pasar->id }}" @selected($retribusi->pasar_id == $pasar->id)>
                                        {{ $pasar->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('pasar_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @else
                            <input type="hidden" name="pasar_id" id="" value="{{ Auth::user()->pasar_id }}">
                            @endif
                            <input type="hidden" name="user_id" id="" value="{{ Auth::user()->id }}">
                            <div class="form-group">
                                <label for="">Nama Pedagang</label>
                                <input required type="text"
                                    value="{{ old('nama_pedagang', $retribusi->nama_pedagang) }}" name="nama_pedagang"
                                    class="form-control">
                                @error('nama_pedagang')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input required type="text" value="{{ old('alamat', $retribusi->alamat) }}"
                                    name="alamat" class="form-control">
                                @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_retribusi">Jenis Retribusi</label>
                                <select required class="form-control" name="jenis_retribusi" id="jenis_retribusi">
                                    <option>-Pilih jenis retribusi-</option>
                                    <option value="Parkir" @selected(old('jenis_retribusi', $retribusi->jenis_retribusi)
                                        == 'Parkir')>Parkir</option>
                                    <option value="Kebersihan" @selected(old('jenis_retribusi', $retribusi->
                                        jenis_retribusi) == 'Kebersihan')>Kebersihan</option>
                                    <option value="Izin Usaha" @selected(old('jenis_retribusi', $retribusi->
                                        jenis_retribusi) == 'Izin Usaha')>Izin Usaha</option>
                                    <option value="Pengelolaan Air" @selected(old('jenis_retribusi', $retribusi->
                                        jenis_retribusi) == 'Pengelolaan Air')>Pengelolaan Air</option>
                                    <option value="Penggunaan Jalan" @selected(old('jenis_retribusi', $retribusi->
                                        jenis_retribusi) == 'Penggunaan Jalan')>Penggunaan Jalan</option>
                                    <option value="Sampah" @selected(old('jenis_retribusi', $retribusi->jenis_retribusi)
                                        == 'Sampah')>Sampah</option>
                                    <option value="Keamanan" @selected(old('jenis_retribusi', $retribusi->
                                        jenis_retribusi) == 'Keamanan')>Keamanan</option>
                                    <option value="Perizinan Bangunan" @selected(old('jenis_retribusi', $retribusi->
                                        jenis_retribusi) == 'Perizinan Bangunan')>Perizinan Bangunan</option>
                                    <option value="Penggunaan Fasilitas Umum" @selected(old('jenis_retribusi',
                                        $retribusi->jenis_retribusi) == 'Penggunaan Fasilitas Umum')>Penggunaan
                                        Fasilitas Umum</option>
                                </select>
                                @error('jenis_retribusi')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Jumlah</label>
                                <input required type="number"
                                    value="{{ old('jumlah_pembayaran', $retribusi->jumlah_pembayaran) }}"
                                    name="jumlah_pembayaran" class="form-control">
                                @error('jumlah_pembayaran')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <select required class="form-control" name="metode_pembayaran" id="metode_pembayaran">
                                    <option>-Pilih metode pembayaran-</option>
                                    <option value="Tunai" @selected(old('metode_pembayaran', $retribusi->
                                        metode_pembayaran) == 'Tunai')>Tunai</option>
                                    <option value="Transfer Bank" @selected(old('metode_pembayaran', $retribusi->
                                        metode_pembayaran) == 'Transfer Bank')>Transfer Bank</option>
                                    <option value="Kartu Kredit" @selected(old('metode_pembayaran', $retribusi->
                                        metode_pembayaran) == 'Kartu Kredit')>Kartu Kredit</option>
                                    <option value="Kartu Debit" @selected(old('metode_pembayaran', $retribusi->
                                        metode_pembayaran) == 'Kartu Debit')>Kartu Debit</option>
                                    <option value="E Wallet" @selected(old('metode_pembayaran', $retribusi->
                                        metode_pembayaran) == 'E Wallet')>E-Wallet</option>
                                </select>
                                @error('metode_pembayaran')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <select required class="form-control" name="keterangan" id="keterangan">
                                    <option>-Pilih keterangan-</option>
                                    <option value="Lunas" @selected(old('keterangan', $retribusi->keterangan) ==
                                        'Lunas')>Lunas</option>
                                    <option value="Belum Lunas" @selected(old('keterangan', $retribusi->keterangan) ==
                                        'Belum Lunas')>Belum Lunas</option>
                                </select>
                                @error('keterangan')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- Modal delete harga --}}
@foreach ($retribusis as $retribusi )
<div class="modal fade" id="deleteModal{{ $retribusi->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLabel">Delete Data
                    <kbd>{{ $retribusi->nama_pedagang }}</kbd></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('retribusi.destroy',$retribusi->id) }}}}" class="mb-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <h2 class="text-dark">Apakah anda yakin ingin menghapus <span
                            class="badge badge-danger">{{ $retribusi->nama_pedagang }}</span> ?? </h2>
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

{{-- Modal Filter Data --}}
<div class="modal modal-filter" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-filter fa-sm"></i> Filter Data </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="get">
                        <div class="form-group">
                            <label for="search-text">Pencarian:</label>
                            <div class="input-group">
                                <input required type="text" class="form-control" name="search" value="{{ request('search') }}"
                                    placeholder="Cari Nama Pedagang atau Alamat">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form method="get">
                        <div class="form-group">
                            <label for="search-date">Tanggal:</label>
                            <div class="input-group">
                                <input required type="date" class="form-control" name="searchdate">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Export Data --}}
<div class="modal modal-export" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-excel"></i> Export Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form method="get" action="{{ route('export.retribusi') }}">
                        @csrf
                        <div class="form-group">
                            <label for="search-date">Tanggal:</label>
                            <div class="input-group">
                                <input required type="date" class="form-control" name="date">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">Export</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- show/hide input field modal input --}}

{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
    integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>

<script>
    $(function () {
        $('.alert').delay(2000).fadeOut();
    });

</script>
<script>
    $(document).ready(function () {
        // Show the element when the "Show Element" button is clicked
        $("#showButton").click(function () {
            $("#myElement").show();
        });

        // Hide the element when the "Hide Element" button is clicked
        $("#hideButton").click(function () {
            $("#myElement").hide();
        });
    });

</script>

{{-- show/hide input field modal edit --}}
<script>
    $(document).ready(function () {
        // Show the element when the "Show Element" button is clicked
        $("#showButton2").click(function () {
            $("#myElement2").show();
        });

        // Hide the element when the "Hide Element" button is clicked
        $("#hideButton2").click(function () {
            $("#myElement2").hide();
        });
    });

</script>
<!-- Tambahkan kode jQuery untuk membuka modal -->
@if ($errors->any())
<script>
    $(document).ready(function () {
        $('#inputModal').modal('show');
    });

</script>


{{-- Select2 --}}
<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });

</script>
@endif










@endsection
