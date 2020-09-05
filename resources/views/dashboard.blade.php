@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-4">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">Grafik Pendapatan Desa Adat Ketewel</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" id="btn1IndoSembuh">
                                        <a href="#" class="nav-link py-2 px-3 active show" data-toggle="tab" id="btn1IndoSembuh">
                                            <span class="d-none d-md-block">Harian</span>
                                            <span class="d-md-none">Harian</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="btn2IndoSembuh">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab" id="btn2IndoSembuh">
                                            <span class="d-none d-md-block">Bulanan</span>
                                            <span class="d-md-none">Bulanan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-orderss-sembuh" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">10 Transaksi Debit Terakhir</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= sizeof($pendapatans); $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $pendapatans[$i-1]->nama_trans }}</td>
                                        <td>  {{"Rp ".number_format($pendapatans[$i-1]->nominal,0,",",".")  }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                         
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-4">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">Grafik Pengeluaran Desa Adat Ketewel</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" id="btn1IndoMeninggal">
                                        <a href="#" class="nav-link py-2 px-3 active show" data-toggle="tab" id="btn1IndoMeninggal">
                                            <span class="d-none d-md-block">Harian</span>
                                            <span class="d-md-none">Harian</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="btn2IndoMeninggal">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab" id="btn2IndoMeninggal">
                                            <span class="d-none d-md-block">Bulanan</span>
                                            <span class="d-md-none">Bulanan</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-orderss-meninggal" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">10 Transaksi Kredit Terakhir</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= sizeof($pengeluarans); $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $pengeluarans[$i-1]->nama_trans }}</td>
                                        <td>  {{"Rp ".number_format($pengeluarans[$i-1]->nominal*-1,0,",",".")  }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

<!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="{{ asset('argon') }}/js/addons/datatables.min.js"></script>
<script src="/argon/js/argon.js"></script>

<script>
    var OrdersChartIndoSembuh = (function() {

    var $chartIndoSembuh = $('#chart-orderss-sembuh');
    var $ordersSelectIndoSembuh = $('[name="ordersSelect"]');


    //
    // Methods
    //

    // Init chart
    function initChart($chartIndoSembuh) {

        // Create chart
        var ctxIndoSembuh = document.getElementById('chart-orderss-sembuh').getContext('2d');

        window.ordersChartIndoSembuh = new Chart(ctxIndoSembuh, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     //return '$' + value + 'k'
                                //     return value
                                // }

                                if(parseInt(value) >= 1000){
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }else if(value == 0){
                                    return value = "0";
                                } else{
                                    return value;
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                            // var label = data.datasets[item.datasetIndex].label || '';
                            // var yLabel = item.yLabel;
                            // var content = '';

                            // if (data.datasets.length > 1) {
                            //     content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            // }

                            // content += '<span class="popover-body-value">' + yLabel + '</span>';
                            
                            // return content;

                            var value = data.datasets[item.datasetIndex].data[item.index];

                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else if(value == 0){
                                return value = "0";
                            } else{
                                return value;
                            }
                        }
                    }
                }
            },
            data: {
                labels: {!! json_encode($tanggalPendapatan) !!},
                datasets: [{
                    label: 'performance',
                    data: {!! json_encode($nominalPendapatan) !!}
                }]
            }
        });
    
            // Save to jQuery object
        function removeData(chartIndoSembuh) {
            chartIndoSembuh.destroy();
        }

        function addData(chartIndoSembuh, label, data) {
            
        }
    $("#btn1IndoSembuh").on("click", function() {
        
        if(window.ordersChartIndoSembuh && window.ordersChartIndoSembuh !== null){
            window.ordersChartIndoSembuh.destroy();
        }

        var label = {!! json_encode($tanggalPendapatan) !!}
        var data = {!! json_encode($nominalPendapatan) !!}

        window.ordersChartIndoSembuh = new Chart(ctxIndoSembuh, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     //return '$' + value + 'k'
                                //     return value
                                // }

                                if(parseInt(value) >= 1000){
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }else if(value == 0){
                                    return value = "0";
                                } else{
                                    return value;
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                           

                            var value = data.datasets[item.datasetIndex].data[item.index];

                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else if(value == 0){
                                return value = "0";
                            } else{
                                return value;
                            }
                        }
                    }
                }
            },
            data: {
                labels: label,
                datasets: [{
                    label: 'performance',
                    data: data
                }]
            }
        });
        ordersChartIndoSembuh.update();
    });
    $("#btn2IndoSembuh").on("click", function() {

        if(window.ordersChartIndoSembuh && window.ordersChartIndoSembuh !== null){
            window.ordersChartIndoSembuh.destroy();
        }

        var label = {!! json_encode($tanggalPendapatanBulanan) !!}
        var data = {!! json_encode($nominalPendapatanBulanan) !!}

        window.ordersChartIndoSembuh = new Chart(ctxIndoSembuh, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     //return '$' + value + 'k'
                                //     return value
                                // }

                                if(parseInt(value) >= 1000){
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }else if(value == 0){
                                    return value = "0";
                                } else{
                                    return value;
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                           

                            var value = data.datasets[item.datasetIndex].data[item.index];

                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else if(value == 0){
                                return value = "0";
                            } else{
                                return value;
                            }
                        }
                    }
                }
            },
            data: {
                labels: label,
                datasets: [{
                    label: 'performance',
                    data: data
                }]
            }
        });
        ordersChartIndoSembuh.update();
    });
        $chartIndoSembuh.data('chartIndoSembuh', ordersChartIndoSembuh);
        
    }

    // Init chart
    if ($chartIndoSembuh.length) {
        initChart($chartIndoSembuh);
    }
    })();
</script>

<script>
    var OrdersChartIndoMeninggal = (function() {

    var $chartIndoMeninggal = $('#chart-orderss-meninggal');
    var $ordersSelectIndoMeninggal = $('[name="ordersSelect"]');


    //
    // Methods
    //

    // Init chart
    function initChart($chartIndoMeninggal) {

        // Create chart
        var ctxIndoMeninggal = document.getElementById('chart-orderss-meninggal').getContext('2d');

        window.ordersChartIndoMeninggal = new Chart(ctxIndoMeninggal, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     //return '$' + value + 'k'
                                //     return value
                                // }

                                if(parseInt(value) >= 1000){
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }else if(value == 0){
                                    return value = "0";
                                } else{
                                    return value;
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                            // var label = data.datasets[item.datasetIndex].label || '';
                            // var yLabel = item.yLabel;
                            // var content = '';

                            // if (data.datasets.length > 1) {
                            //     content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            // }

                            // content += '<span class="popover-body-value">' + yLabel + '</span>';
                            
                            // return content;

                            var value = data.datasets[item.datasetIndex].data[item.index];

                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else if(value == 0){
                                return value = "0";
                            } else{
                                return value;
                            }
                        }
                    }
                }
            },
            data: {
                labels: {!! json_encode($tanggalPengeluaran) !!},
                datasets: [{
                    label: 'performance',
                    data: {!! json_encode($nominalPengeluaran) !!}
                }]
            }
        });
    
            // Save to jQuery object
        function removeData(chartIndoMeninggal) {
            chartIndoMeninggal.destroy();
        }

        function addData(chartIndoMeninggal, label, data) {
            
        }
    $("#btn1IndoMeninggal").on("click", function() {
    

        if(window.ordersChartIndoMeninggal && window.ordersChartIndoMeninggal !== null){
            window.ordersChartIndoMeninggal.destroy();
        }

        var label = {!! json_encode($tanggalPengeluaran) !!}
        var data = {!! json_encode($nominalPengeluaran) !!}

        window.ordersChartIndoMeninggal = new Chart(ctxIndoMeninggal, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     //return '$' + value + 'k'
                                //     return value
                                // }

                                if(parseInt(value) >= 1000){
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }else if(value == 0){
                                    return value = "0";
                                } else{
                                    return value;
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                            // var label = data.datasets[item.datasetIndex].label || '';
                            // var yLabel = item.yLabel;
                            // var content = '';

                            // if (data.datasets.length > 1) {
                            //     content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            // }

                            // content += '<span class="popover-body-value">' + yLabel + '</span>';
                            
                            // return content;

                            var value = data.datasets[item.datasetIndex].data[item.index];

                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else if(value == 0){
                                return value = "0";
                            } else{
                                return value;
                            }
                        }
                    }
                }
            },
            data: {
                labels: label,
                datasets: [{
                    label: 'performance',
                    data: data
                }]
            }
        });
        ordersChartIndoMeninggal.update();
    });
    $("#btn2IndoMeninggal").on("click", function() {

        if(window.ordersChartIndoMeninggal && window.ordersChartIndoMeninggal !== null){
            window.ordersChartIndoMeninggal.destroy();
        }

        var label = {!! json_encode($tanggalPengeluaranBulanan) !!}
        var data = {!! json_encode($nominalPengeluaranBulanan) !!}

        window.ordersChartIndoMeninggal = new Chart(ctxIndoMeninggal, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     //return '$' + value + 'k'
                                //     return value
                                // }

                                if(parseInt(value) >= 1000){
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }else if(value == 0){
                                    return value = "0";
                                } else{
                                    return value;
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                            // var label = data.datasets[item.datasetIndex].label || '';
                            // var yLabel = item.yLabel;
                            // var content = '';

                            // if (data.datasets.length > 1) {
                            //     content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            // }

                            // content += '<span class="popover-body-value">' + yLabel + '</span>';
                            
                            // return content;

                            var value = data.datasets[item.datasetIndex].data[item.index];

                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }else if(value == 0){
                                return value = "0";
                            } else{
                                return value;
                            }
                        }
                    }
                }
            },
            data: {
                labels: label,
                datasets: [{
                    label: 'performance',
                    data: data
                }]
            }
        });
        ordersChartIndoMeninggal.update();
    });
        $chartIndoMeninggal.data('chartIndoMeninggal', ordersChartIndoMeninggal);
        
    }

    // Init chart
    if ($chartIndoMeninggal.length) {
        initChart($chartIndoMeninggal);
    }
    })();
</script>

@endpush