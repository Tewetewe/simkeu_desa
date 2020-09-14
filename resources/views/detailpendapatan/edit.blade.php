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
                                <h2 class="mb-0">Detail Transaksi Pendapatan Desa</h2>
                            </div>
                        </div>
                    </div>

                     <!-- Form Cari Data Dunia -->
                     <div class="p-4 bg-secondary">
                     <form action="/detailpendapatan/edit/{{$detailtransaksi->id_detail_transaksi}}" method="POST">
                        @method("PUT")
                            @csrf
                            {{-- <div class="form-group" {{ ($errors->has('roll'))?'has-error':'' }}>
                                <label for="roll">Kategori Pendapatan (Pilih Kategori Pendapatan)</label>
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="" selected disabled hidden>--Pilih Kategori--</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{$kategori->id_ktg_transaksi}}">{{ucfirst($kategori->nama)}}</option>      
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"  {{ ($errors->has('name'))?'has-error':'' }}>
                                <label for="roll">Sub Kategori Pendapatan (Pilih Sub Kategori Pendapatan)</label>
                                <select class="form-control" id="subkategori" name="subkategori">
                                </select>
                            </div>
                            <div class="form-group"  {{ ($errors->has('name'))?'has-error':'' }}>
                                <label for="roll">Sub 2 Kategori Pendapatan (Pilih Sub 2 Kategori Pendapatan)</label>
                                <select class="form-control" id="sub2kategori" name="sub2kategori">
                                </select>
                            </div> --}}
        
                            <div class="form-group">
                                <label for="example-text-input">No. Bukti (Masukkan Nomer Bukti)</label>
                            <input required class="form-control" type="text" name="nobukti" id="example-text-input" value="{{$detailtransaksi->no_bukti_detail}}">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Nama (Masukkan Nama Item)</label>
                            <input required class="form-control" type="text" name="nama" id="example-text-input" value="{{$detailtransaksi->nama_item}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Harga Satuan (Masukkan Harga Satuan)</label>
                            <input required class="form-control" type="number" name="harga" id="example-text-input" value="{{$detailtransaksi->harga}}">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Jumlah (Masukkan Jumlah Barang)</label>
                            <input required class="form-control" type="number" name="jumlah" id="example-text-input" value="{{$detailtransaksi->jumlah}}">
                            </div>
                                      <div class="form-group">
                                <label for="example-text-input">Pilih Satuan (Pilih Satuan yang Tersedia)</label>
                                <select class="form-control" id="drop" name="satuan" required value="{{$detailtransaksi->satuan}}">
                                    <option value="" selected disabled hidden>Pilih Satuan</option>
                                    <option value="pcs"  @if($detailtransaksi->satuan=="pcs") selected='selected' @endif>pcs</option>
                                    <option value="lusin"  @if($detailtransaksi->satuan=="lusin") selected='selected' @endif>lusin</option>
                                    <option value="dus"  @if($detailtransaksi->satuan=="dus") selected='selected' @endif>dus</option>
                                    <option value="meter"  @if($detailtransaksi->satuan=="meter") selected='selected' @endif>meter</option>
                                    <option value="buah"  @if($detailtransaksi->satuan=="buah") selected='selected' @endif>buah</option>
                                    <option value="pepel"  @if($detailtransaksi->satuan=="pepel") selected='selected' @endif>pepel</option>
                                    <option value="bulan"  @if($detailtransaksi->satuan=="bulan") selected='selected' @endif>bulan</option>
                                    <option value="orang"  @if($detailtransaksi->satuan=="orang") selected='selected' @endif>orang</option>
                                    <option value="liter"  @if($detailtransaksi->satuan=="liter") selected='selected' @endif>liter</option>
                                    <option value="kodi"  @if($detailtransaksi->satuan=="kodi") selected='selected' @endif>kodi</option>
                                    <option value="hari"  @if($detailtransaksi->satuan=="hari") selected='selected' @endif>hari</option>
                                    <option value="tahun"  @if($detailtransaksi->satuan=="tahun") selected='selected' @endif>tahun</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Tanggal Penerimaan (Masukkan Tanggal Penerimaan Dana)</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                <input required class="form-control datepicker" type="text" name= "tanggal" value="{{$detailtransaksi->tanggal_detail}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Keterangan (Masukkan Keterangan Detail Pendapatan)</label>
                            <input required class="form-control" type="text" name="keterangan" id="example-text-input" value="{{$detailtransaksi->keterangan}}" >
                            </div>
                            
                        
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

    <script>
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>
        <script type="text/javascript" src="{{ asset('argon')}}/js/bootstrap.min.js"></script>
        <script>
                $(document).ready(function() {
                    $('#kategori').on('change', function() {
                        var kategoriID = $(this).val();
                        if(kategoriID) {
                            $.ajax({
                                url: '/findSubKategori/'+kategoriID,
                                type: "GET",
                                data : {"_token":"{{ csrf_token() }}"},
                                dataType: "json",
                                success:function(data) {
                                    //console.log(data);
                                if(data){
                                    $('#subkategori').empty();
                                    $('#subkategori').focus;
                                    $('#subkategori').append('<option value="">-- Pilih Sub Kategori --</option>'); 
                                    $.each(data, function(key, value){
                                    $('select[name="subkategori"]').append('<option value="'+ value.id_sub_ktg +'">' + value.nama_sub+ '</option>');
                                });
                            }else{
                                $('#subkategori').empty();
                            }
                            }
                            });
                        }else{
                        $('#subkategori').empty();
                        }
                    });
                
                });
                $(document).ready(function() {
                    $('#subkategori').on('change', function() {
                            var subKategoriID = $(this).val();
                            if(subKategoriID) {
                                $.ajax({
                                    url: '/findSub2Kategori/'+subKategoriID,
                                    type: "GET",
                                    data : {"_token":"{{ csrf_token() }}"},
                                    dataType: "json",
                                    success:function(data) {
                                        console.log(data);
                                    if(data){
                                        $('#sub2kategori').empty();
                                        $('#sub2kategori').focus;
                                        $('#sub2kategori').append('<option value="">-- Pilih Sub 2 Kategori --</option>'); 
                                        $.each(data, function(key, value){
                                        $('select[name="sub2kategori"]').append('<option value="'+ value.id_sub_2 +'">' + value.nama_sub_2+ '</option>');
                                    });
                                }else{
                                    $('#sub2kategori').empty();
                                }
                                }
                                });
                            }else{
                            $('#sub2kategori').empty();
                            }
                        });
                    });
        </script>
    
    <script type="text/javascript" src="{{ asset('argon') }}/js/addons/datatables.min.js"></script>
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