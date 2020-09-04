@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">Debit</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="k">
                                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block">Harian</span>
                                            <span class="d-md-none">H</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                            <span class="d-none d-md-block">Bulanan</span>
                                            <span class="d-md-none">B</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-sales" class="chart-canvas"></canvas>
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
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">Kredit</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-orders" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="k">
                                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block">Harian</span>
                                            <span class="d-md-none">H</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" data-toggle="chart" data-target="#chart-orders" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                            <span class="d-none d-md-block">Bulanan</span>
                                            <span class="d-md-none">B</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-orders" class="chart-canvas"></canvas>
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
{{-- 
<script src="/argon/js/argon.js"></script>
<script>
    'use strict';
    
    var SalesChart = (function() {

    // Variables

    var $chart = $('#chart-saless');


    // Methods

    function init($chart) {

        var salesChart = new Chart($chart, {
            type: 'line',
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: Charts.colors.gray[900],
                            zeroLineColor: Charts.colors.gray[900]
                        },
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     return value;
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

                            // content += yLabel ;
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
                labels: {!! json_encode($positifDate) !!},
                datasets: [{
                    label: 'permormance',
                    data: {!! json_encode($dataPositif) !!}
                }]
            }
        });

        // Save to jQuery object

        $chart.data('chart', salesChart);

    };


    // Events

    if ($chart.length) {
        init($chart);
    }

    })();
</script>
<script>
    var OrdersChartIndo = (function() {

    var $chartIndo = $('#chart-orderss');
    var $ordersSelectIndo = $('[name="ordersSelect"]');


    //
    // Methods
    //

    // Init chart
    function initChart($chartIndo) {

        // Create chart
        var ctxIndo = document.getElementById('chart-orderss').getContext('2d');

        window.ordersChartIndo = new Chart(ctxIndo, {
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
                labels: {!! json_encode($positifDate) !!},
                datasets: [{
                    label: 'performance',
                    data: {!! json_encode($dataPositif) !!}
                }]
            }
        });
    
            // Save to jQuery object
        function removeData(chartIndo) {
            chartIndo.destroy();
        }

        function addData(chartIndo, label, data) {
            
        }
    $("#btn1Indo").on("click", function() {
        // var chart = ordersChart
        // var label = {!! json_encode($positifDateProv) !!}
        // var data = {!! json_encode($dataPositifProv) !!}

        // chart.data.labels.pop();
        // chart.data.datasets.forEach((dataset) => {
        //     dataset.data.pop();
        // });
        // chart.update();

        if(window.ordersChartIndo && window.ordersChartIndo !== null){
            window.ordersChartIndo.destroy();
        }

        var label = {!! json_encode($positifDate) !!}
        var data = {!! json_encode($dataPositif) !!}

        window.ordersChartIndo = new Chart(ctxIndo, {
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
        ordersChartIndo.update();
    });
    $("#btn2Indo").on("click", function() {

        if(window.ordersChartIndo && window.ordersChartIndo !== null){
            window.ordersChartIndo.destroy();
        }

        var label = {!! json_encode($positifDateDiff) !!}
        var data = {!! json_encode($dataPositifDiff) !!}

        window.ordersChartIndo = new Chart(ctxIndo, {
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
        ordersChartIndo.update();
    });
        $chartIndo.data('chartIndo', ordersChartIndo);
        
    }

    // Init chart
    if ($chartIndo.length) {
        initChart($chartIndo);
    }
    })();
</script>
<script>
    'use strict';
    
    var SalesChartBali = (function() {

    // Variables

    var $chartBali = $('#chart-saless-bali');


    // Methods

    function init($chartBali) {

        var salesChartBali = new Chart($chartBali, {
            type: 'line',
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: Charts.colors.gray[900],
                            zeroLineColor: Charts.colors.gray[900]
                        },
                        ticks: {
                            callback: function(value) {
                                // if (!(value % 10)) {
                                //     return value;
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

                            //char content += yLabel ;
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
                labels: {!! json_encode($positifDateBali) !!},
                datasets: [{
                    label: 'performance',
                    data: {!! json_encode($arrayPositif) !!}
                }]
            }
        });

        // Save to jQuery object

        $chartBali.data('chart', salesChartBali);

    };


    // Events

    if ($chartBali.length) {
        init($chartBali);
    }

    })();
</script>
<script>
    var OrdersChartBali = (function() {

    var $chartBali = $('#chart-orderss-bali');
    var $ordersSelectBali = $('[name="ordersSelect"]');


    //
    // Methods
    //

    // Init chart
    function initChart($chartBali) {

        // Create chart
        var ctxBali = document.getElementById('chart-orderss-bali').getContext('2d');

        window.ordersChartBali = new Chart(ctxBali, {
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
                labels: {!! json_encode($positifDateBali) !!},
                datasets: [{
                    label: 'performance',
                    data: {!! json_encode($dataPositifBali) !!}
                }]
            }
        });
    
            // Save to jQuery object
        function removeData(chartBali) {
            chartBali.destroy();
        }

        function addData(chartBali, label, data) {
            
        }
    $("#btn1Bali").on("click", function() {
        // var chart = ordersChart
        // var label = {!! json_encode($positifDateProv) !!}
        // var data = {!! json_encode($dataPositifProv) !!}

        // chart.data.labels.pop();
        // chart.data.datasets.forEach((dataset) => {
        //     dataset.data.pop();
        // });
        // chart.update();

        if(window.ordersChartBali && window.ordersChartBali !== null){
            window.ordersChartBali.destroy();
        }

        var label = {!! json_encode($positifDateBali) !!}
        var data = {!! json_encode($dataPositifBali) !!}

        window.ordersChartBali = new Chart(ctxBali, {
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
        ordersChartBali.update();
    });
    $("#btn2Bali").on("click", function() {

        if(window.ordersChartBali && window.ordersChartBali !== null){
            window.ordersChartBali.destroy();
        }

        var label = {!! json_encode($positifDateBaliDiff) !!}
        var data = {!! json_encode($dataPositifBaliDiff) !!}

        window.ordersChartBali = new Chart(ctxBali, {
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
        ordersChartBali.update();
    });
        $chartBali.data('chartBali', ordersChartBali);
        
    }

    // Init chart
    if ($chartBali.length) {
        initChart($chartBali);
    }
    })();
</script> --}}

@endpush