@extends('dashboard.layouts.app')
{{-- JUDUL --}}
@section('title')
    Dashboard
@endsection

@section('container')


<head>
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
    integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


</head>
  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total retribusi di input</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalretribusi }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    @can('admin')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Akun
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{ $totaluser }}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endcan
    
    @can('admin')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pasar
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalpasar }}</div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(@json($chartData));

            var options = {
                title: 'Total Pendapatan Retribusi Tertinggi pada tiap Pasar',
                chartArea: {
                    width: '70%',  // Mengatur area chart untuk memperkecil margin
                    height: '70%'
                },
                hAxis: {
                    title: 'Nama Pasar'
                },
                vAxis: {
                    title: 'Jumlah Pembayaran',
                    minValue: 0
                },
                bar: {groupWidth: '15%'}
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('column_chart'));

            chart.draw(data, options);
        }
    </script>

<div id="column_chart" style="width: 1170px; height: 500px;"></div>



@endsection

