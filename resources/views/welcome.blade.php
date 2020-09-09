@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header body py-8 py-lg-9">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Selamat Datang di Sistem Keuangan Desa Adat Ketewel') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection

<style> 
    .body {
        background-image: url("{{ asset('argon') }}/img/brand/cover.png");
        
    }
</style>
    