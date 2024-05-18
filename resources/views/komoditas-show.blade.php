@extends('frontend.layouts.main')
{{-- JUDUL --}}
@section('title')
Komoditas
@endsection

@section('container')

<head>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    --}}
    <br>
    <div class="text-center text-dark">
        <h2><strong>[{{ $komoditas->nama }}]</strong></h2>
    </div>
    <section>
        <div class="container">


            <div class="d-flex justify-content-center">
                <form action="/komoditas/{{ $komoditas->nama }}" method="get">
                    <div class="row g-3 mb-2">
                        {{-- <div class="col-auto">
                                  <label  class="col-form-label">Search Data</label>
                                </div> --}}
                        <div class="col-auto text-center">
                            <select name="pasar" class="form-control" id="">

                                <option selected value="" class="text-center">

                                    @if (request('pasar'))
                                    {{ request('pasar') }}
                                    @else
                                    -Semua Pasar-
                                    @endif

                                </option>
                                {{-- @foreach ($pasars as $pasar)
                                        <option>{{ $pasar->nama }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Filter</button>

                        </div>
                    </div>
                </form>
            </div>

            <div class="container">
                <div class="d-flex justify-content-center">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' .$komoditas->image) }}" class="img-fluid rounded-start"
                                    alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="row d-flex flex-wrap">
                                      @foreach ($komoditas->barangs as $barang)
                                      <div class="col-md-3">
                                          <div class="card">
                                              <img src="{{ asset('storage/' .$barang->image) }}" alt="{{ $barang->nama }}" class="card-img-top">
                                              <div class="card-body align-items-center">
                                                  <h5 class="card-title">{{ $barang->nama }}</h5>
                                                  @if ($barang->pangans->isNotEmpty())
                                                      <p class="card-text">Harga: Rp{{ number_format($barang->pangans->last()->harga) }}</p>
                                                  @else
                                                      <p class="card-text">Harga tidak tersedia</p>
                                                  @endif
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                                  
                                  
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </section>
    @endsection
