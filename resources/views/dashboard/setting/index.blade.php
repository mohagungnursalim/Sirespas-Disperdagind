@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Pengaturan Aplikasi
@endsection

@section('container')


<div class="row mt-3">

    <!-- Area Chart -->
    @can('admin')
    <div class="col-xl-8 col-lg-7">
        <!-- Card 1 - Nama App -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Nama App</h6>
                <div class="dropdown no-arrow">

                </div>
            </div>
            <!-- Card Body -->
            @foreach ($settings as $setting)

            <div class="card-body">
                <form method="post" action="{{ route('setting-app.update',$setting->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="">Nama App</label>
                        <input type="text" value="{{ $setting->nama }}" required class="form-control" name="nama"><br>
                        <label for="">Alamat</label>
                        <input type="text" value="{{ $setting->alamat }}" required class="form-control" name="alamat"><br>
                        <label for="">Email</label>
                        <input type="text" value="{{ $setting->email }}" required class="form-control" name="email"><br>
                        <label for="">Telepon</label>
                        <input type="text" value="{{ $setting->telepon }}" required class="form-control" name="telepon">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>

                </form>
            </div>
            @endforeach
        </div>

        <!-- Card 2 - Header/Title -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Header/Title</h6>
                <div class="dropdown no-arrow">

                </div>
            </div>
            <!-- Card Body -->
            @foreach ($settings as $setting)

            <div class="card-body">
                <form method="post" action="{{ route('update-text',$setting->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="">Masukan Text</label>
                        <textarea name="text" id="" class="form-control" cols="30"
                            rows="2">{{ $setting->text }}</textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>

                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Card di sisi kanan -->
    <div class="col-xl-4 col-lg-5">
        <!-- Card 3 - Tambahan di sisi kanan -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Copyright</h6>
                <div class="dropdown no-arrow">

                </div>
            </div>
           <!-- Card Body -->
           @foreach ($settings as $setting)

           <div class="card-body">
               <form method="post" action="{{ route('update-copyright',$setting->id) }}">
                   @csrf
                   @method('put')
                   <div class="form-group">
                       <label for="">Masukan Copyright</label>
                       <textarea name="copyright" id="" class="form-control" cols="3"
                            rows="4">{{ $setting->copyright }}</textarea>
                   </div>
                   <div class="text-center">
                       <button type="submit" class="btn btn-success">Simpan</button>
                   </div>

               </form>
           </div>

           
           @endforeach
            <!-- Isi card di sini sesuai kebutuhan -->
        </div>
    </div>

</div>

   @endcan

@endsection