@extends('frontend.layouts.main')
{{-- JUDUL --}}
@section('title')
@foreach ($settings as $setting )
{{ $setting->nama }}
@endforeach | Kota Palu
@endsection

@section('container')

<head>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    --}}
    <br>
    <div class="text-center text-dark mt-2">
        <h2><b>Harga Bahan Pokok dan Penting</b></h2>
    </div>
    <section id="harga" class="harga">

        
        <div class="container">

            <div class="d-flex justify-content-center">
                <form action="{{ route('search') }}" method="get">
                    <div class="row g-3 align-items-center mb-2">
                        <div class="col-auto">
                            <input type="text" value="{{request('search_query')}}" class="form-control"
                                placeholder="Kata Kunci.." name="search_query">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Cari</button>

                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-auto d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card-body">


                        <div class="row d-flex flex-wrap">
                            @foreach ($barangs as $barang)
                            <div class="col-md-3 mt-3">
                                <div class="card">
                                    <img src="{{ asset('storage/' .$barang->image) }}" alt="{{ $barang->nama }}"
                                        class="card-img-top">
                                    <div class="card-body align-items-center">
                                        <h5 class="card-title">{{ $barang->nama }}</h5>
                                        @if ($barang->pangans->isNotEmpty())
                                        <p class="card-text">Harga rata-rata:
                                            Rp{{ number_format($barang->pangans->avg('harga')) }}
                                        </p>
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

            <div class="d-flex justify-content-center mt-3">
                {{$barangs->links()}}
            </div>

        </div>
        

    </section>
    @endsection
