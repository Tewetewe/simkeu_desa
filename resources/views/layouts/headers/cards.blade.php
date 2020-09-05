<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Debit</h5>
                                    <span class="h2 font-weight-bold mb-0"> {{"Rp ".number_format($debit,0,",",".")  }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    @if($lastDebit >= 0)
                                    <i class="fa fa-arrow-up">
                                    @else
                                    <i class="fa fa-arrow-down">
                                    @endif
                                    </i>{{"Rp ".number_format($lastDebit,0,",",".")  }}</i></span>
                                <span class="text-nowrap">Sejak Transaksi Terakhir</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Kredit</h5>
                                    <span class="h2 font-weight-bold mb-0">{{"Rp ".number_format($kredit*-1,0,",",".")  }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-danger mr-2">
                                    @if($lastKredit <= 0)
                                    <i class="fa fa-arrow-up">
                                    @else
                                    <i class="fa fa-arrow-down">
                                    @endif
                                    </i>{{"Rp ".number_format($lastKredit*-1,0,",",".")  }}</span>
                                <span class="text-nowrap">Sejak Transaksi Terakhir</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">SALDO</h5>
                                    <span class="h2 font-weight-bold mb-0">{{"Rp ".number_format($saldo,0,",",".")  }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2">
                                    @if($lastSaldo >= 0)
                                    <i class="fa fa-arrow-up">
                                    @else
                                    <i class="fa fa-arrow-down">
                                    @endif
                                        </i>{{"Rp ".number_format($lastSaldo,0,",",".")  }}</span>
                                <span class="text-nowrap">Sejak Transaksi Terakhir</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">RATIO PENDAPATAN</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$ratio}} %<span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2">
                                @if($lastRatio >= 0)
                                <i class="fa fa-arrow-up">
                                @else
                                <i class="fa fa-arrow-down">
                                @endif
                                    </i>{{$lastRatio}} %</span>
                                <span class="text-nowrap">Sejak Transaksi Terakhir</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>