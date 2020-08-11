@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your projects or assigned tasks'),
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h2 class="mb-0">Master Item</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Form Cari Data Dunia -->
                    <div class="p-4 bg-secondary">
                    <form action="/item/{{$items->id_master_item}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <label for="example-text-input">Kode (Masukkan Item)</label>
                            <input class="form-control" type="text" name="kode" id="example-text-input" required value="{{$items->kode}}">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Nama Item (Masukkan Nama Item)</label>
                                <input class="form-control" type="text" name="nama" id="example-text-input" required value="{{$items->nama_item}}" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Satuan (Pilih Satuan)</label>
                            <select class="form-control" id="drop" name="satuan" required value="{{$items->satuan}}">
                                    <option value="" selected disabled hidden>Pilih Satuan</option>
                                    <option value="pcs"  @if($items->satuan=="pcs") selected='selected' @endif>pcs</option>
                                    <option value="lusin"  @if($items->satuan=="lusin") selected='selected' @endif>lusin</option>
                                    <option value="dus"  @if($items->satuan=="dus") selected='selected' @endif>dus</option>
                                    <option value="meter"  @if($items->satuan=="meter") selected='selected' @endif>meter</option>
                                    <option value="buah"  @if($items->satuan=="buah") selected='selected' @endif>buah</option>
                                    <option value="pepel"  @if($items->satuan=="pepel") selected='selected' @endif>pepel</option>
                                    <option value="bulan"  @if($items->satuan=="bulan") selected='selected' @endif>bulan</option>
                                    <option value="orang"  @if($items->satuan=="orang") selected='selected' @endif>orang</option>
                                    <option value="liter"  @if($items->satuan=="liter") selected='selected' @endif>liter</option>
                                    <option value="kodi"  @if($items->satuan=="kodi") selected='selected' @endif>kodi</option>
                                    <option value="hari"  @if($items->satuan=="hari") selected='selected' @endif>hari</option>
                                    <option value="tahun"  @if($items->satuan=="tahun") selected='selected' @endif>tahun</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Harga (Masukkan Harga)</label>
                                <input class="form-control" type="number" name="harga" id="example-text-input" required value="{{$items->harga}}" >
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleFormControlSelect1">Status (Pilih Status Sub Kategori)</label>
                            <select class="form-control" id="drop" name="status" required value="{{$items->status}}">
                                    <option value="1" @if($items->status==1) selected='selected' @endif>Aktif</option>
                                    <option value="0" @if($items->status==0) selected='selected' @endif>Non Aktif</option>
                            </select>
                            </div> --}}
                            {{-- <div class="input-daterange datepicker row align-items-center">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Start Date (Maksimal input dimulai dari 21 Januari 2020)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="Start date" type="text" name="startDate" value="01/21/2020">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">End Date (Maksimal input tanggal hari ini )</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="End date" type="text" name="endDate" value="01/25/2020">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <input type="submit" class="btn btn-outline-success" value="Simpan Data">
                            <input type="reset" class="btn btn-outline-warning" value="Hapus">
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
        
@endsection

<style>
    .drop {
    min-height:190px; 
    overflow-y :auto; 
    overflow-x:hidden; 
    position:absolute;
    width:300px;
    display: contents;
}
</style>

@push('js')
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="{{ asset('argon') }}/js/addons/datatables.min.js"></script>

    <script>
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({

            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var t = $('#table_import').DataTable({
                "lengthMenu": [[10, 20, 25, 50, 100, -1], [10, 20, 25, 50, 100, "All"]],
                language: {
                    paginate: {
                    next: '>', // or '→'
                    previous: '<' // or '←' 
                    }
                },
                "aaSorting": [],
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }]
            });
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
            var td= $('#table_dunia').DataTable({
                "lengthMenu": [[10, 20, 25, 50, 100, -1], [10, 20, 25, 50, 100, "All"]],
                language: {
                    paginate: {
                    next: '>', // or '→'
                    previous: '<' // or '←' 
                    }
                },
                "aaSorting": [],
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }]

            });
            td.on( 'order.dt search.dt', function () {
                td.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
   
@endpush