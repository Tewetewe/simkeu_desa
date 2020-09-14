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
                                <h2 class="mb-0">Report Pendapatan dan Pengeluaran Desa</h2>
                            </div>
                        </div>
                    </div>
                     <!-- Form Cari Data Dunia -->
                     <div class="p-4 bg-secondary">
                        <form action="/reportTransaksi/filter" method="GET">
                            @csrf
                           
                            <div class="form-group">
                                <label for="example-text-input">Nama (Masukkan Nama Transaksi)</label>
                                <input class="form-control" type="text" name="nama" id="example-text-input" >
                            </div>
                            <div class="input-daterange datepicker row align-items-center">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Start Date (Maksimal input dimulai dari transaksi pertama)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="Start date" type="text" name="startDate" value={{$datenow}}>
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
                                            <input class="form-control datepicker" placeholder="End date" type="text" name="endDate" value={{$datenow}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-outline-success" value="Cari Data">
                            <input type="reset" class="btn btn-outline-warning" value="Hapus">
                            <a href="/reportTransaksi/pdf" class="btn btn-success my-3" target="_blank">Export PDF</a>
                        </form>
                        
                    </div>
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h2 class="mb-2">Total Pendapatan Desa : {{"Rp ".number_format($totalPendapatan,0,",",".")}}</h2>
                                <h2 class="mb-2">Total Pengeluaran Desa : {{"Rp ".number_format($totalPengeluaran*-1,0,",",".")}}</h2>
                                <h2 class="mb-2">Total Saldo Desa : {{"Rp ".number_format($total,0,",",".")}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding-right: 25px;padding-left: 25px;">
                        <!-- Projects table -->
                        <table id="table_import" class="table align-items-center table-striped table-bordered" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">No. Bukti</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Debit</th>
                                        <th scope="col">Kredit</th>
                                        <th scope="col">Saldo</th>
                                        <th scope="col">Keterangan</th>
                                         
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= sizeof($transaksis); $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td> {{$transaksis[$i-1]->tanggal}}</td>
                                            <td>{{ $transaksis[$i-1]->no_bukti}}</td>
                                            <td>{{ $transaksis[$i-1]->nama_trans}}</td>
                                            <td>{{''}}</td>
                                            <td>{{''}}</td>
                                            <td>{{''}}</td>
                                            <td>{{''}}</td>
                                            @if($transaksis[$i-1]->tipe == 1)
                                            <td>  {{"Rp ".number_format($transaksis[$i-1]->nominal,0,",",".")  }}</td>
                                            @else
                                            <td>  {{''}}</td>
                                            @endif
                                            @if($transaksis[$i-1]->tipe == -1)
                                            <td>  {{"Rp ".number_format($transaksis[$i-1]->nominal*-1,0,",",".")  }}</td>
                                            @else
                                            <td>  {{''}}</td>
                                            @endif
                                            <td>  {{"Rp ".number_format($transaksis[$i-1]->subtotal,0,",",".")  }}</td>
                                            <td> {{ $transaksis[$i-1]->keterangan }}</td>
                                          
                                        </tr>
                                        @for ($j = 0; $j < sizeof($transaksis[$i-1]->detail_transaksi); $j++)
                                            <tr>
                                            <td>{{ $i }}.{{$j+1}}</td>
                                                <td>
                                                    {{$transaksis[$i-1]->detail_transaksi[$j]->tanggal_detail}}
                                                </td>
                                                <td>{{ $transaksis[$i-1]->detail_transaksi[$j]->no_bukti_detail}}</td>
                                                <td>{{ $transaksis[$i-1]->detail_transaksi[$j]->nama_item}}</td>
                                                <td>{{$transaksis[$i-1]->detail_transaksi[$j]->jumlah}}</td>
                                                <td>{{$transaksis[$i-1]->detail_transaksi[$j]->satuan}}</td>
                                                <td>{{$transaksis[$i-1]->detail_transaksi[$j]->harga < 0 ? "Rp ".number_format($transaksis[$i-1]->detail_transaksi[$j]->harga*-1,0,",",".") :  "Rp ".number_format($transaksis[$i-1]->detail_transaksi[$j]->harga,0,",",".")  }}</td>
                                                <td>  {{$transaksis[$i-1]->detail_transaksi[$j]->subtotal < 0 ? "Rp ".number_format($transaksis[$i-1]->detail_transaksi[$j]->subtotal*-1,0,",",".") :  "Rp ".number_format($transaksis[$i-1]->detail_transaksi[$j]->subtotal,0,",",".") }}
                                                <td>  {{''}}</td>
                                                <td>  {{''}}</td>
                                                <td>  {{''}}</td>
                                                <td> {{ $transaksis[$i-1]->detail_transaksi[$j]->keterangan_detail }}</td>
                                            </tr>
                                        @endfor
                                    @endfor
                                </tbody>
                            </table>
                        </div> 
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