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
    <div class="text-center text-dark mt-2">
        <h2><b>Tabel Harga</b></h2>
    </div>
    
    <section class="portfolio">
      <div class="container">
        <div class="d-flex justify-content-center">
            <form action="/tabel-harga" method="get">
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-auto">
                        <select class="form-control" name="filter" id="">
                            <option value="">--Pilih Pasar--</option>
                            @foreach ($pasars as $pasar)
                            <option value="{{$pasar->nama}}" {{$pasar->nama === request('filter') ? 'selected' : ''}}>
                                {{$pasar->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="overflow-auto">
            <table class="table table-bordered table-hover table-condensed">
                <tbody>
                    <tr>
                        <th>NO</th>
                        <th>KOMODITAS</th>
                        <th>SATUAN</th>
                        <th>HARGA LAMA</th>
                        <th>HARGA SEKARANG</th>
                        <th class="right">PERUBAHAN (Rp)</th>
                        <th class="right">PERUBAHAN (%)</th>
                    </tr>
                    @php
                        $startIteration = ($komoditas->currentPage() - 1) * $komoditas->perPage() + 1;
                    @endphp
                    @foreach ($komoditas as $kmd)
                    <tr>
                        <td>{{$loop->iteration + $startIteration - 1}}</td>
                        <td>{{$kmd->nama}}</td>
                        <td></td>
                        <td></td>
                        <td class="right sekarang"></td>
                        <td class="right"></td>
                        <td class="right"> <span class=""></span></td>
                    </tr>
        
                    @foreach ($kmd->barangs as $barang)
                    @foreach ($barang->pangans as $pangan)
                    @if ($pangan->pasar === request('filter') || request('filter') == '')
                    <tr>
                        <td></td>
                        <td>- {{$barang->nama}}</td>
                        <td>{{ $pangan->satuan }} @if(isset($pangan->qty)) / Qty:<kbd>{{$pangan->qty}}</kbd> @endif</td>
                        <td class="text-center">
                          @if ($pangan->harga_sebelum)
                              Rp{{number_format($pangan->harga_sebelum)}}
                          @else
                          -
                          @endif
                        </td>
                        <td class="right sekarang text-center">
                            Rp{{ number_format($pangan->harga) }}
                        </td>
                        <td class="right text-center">
                          Rp{{ number_format($pangan->perubahan_rp) }} 
                        </td>
                        <td class="right text-center">
                             {{ number_format($pangan->perubahan_persen) }}%{{$pangan->keterangan}}  
                      </td>
                    </tr>
                    @endif
                    @endforeach

                    @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {{$komoditas->links()}} --}}
                {{$komoditas->links()}}
            </div>
        </div>
        
    </div>
    </section>
    @endsection
