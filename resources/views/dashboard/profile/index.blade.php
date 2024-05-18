@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
Edit Profil
@endsection

@section('container')





        <div class="container mt-3">
           <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Ubah Informasi Profil</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form method="post" action="{{ route('profile.update') }}">
                                        @csrf
                                        @method('patch')
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Nama</label>
                                          <input type="text" value="{{ auth()->user()->name }}" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                          
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputPassword1">Email</label>
                                          <input type="email" class="form-control" name="email" placeholder="Email" value="{{ auth()->user()->email }}">
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                        
                                      </form>
                                </div>
                            </div>
                        </div>

                        <!-- Update Password -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    
                                    <form method="post" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('put')

                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Password Sekarang</label>
                                          <input required type="password" name="current_password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Password sekarang..">
                                          
                                          @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                         @enderror
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputPassword1">Password Baru</label>
                                          <input required type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                          @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                         @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Konfirmasi Password</label>
                                            <input required type="password" name="password_confirmation" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                            @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                          </div>
                                          <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                          </div>
                                        
                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    



@endsection







