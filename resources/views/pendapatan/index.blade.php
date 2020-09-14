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
                                <h2 class="mb-2">Pendapatan Desa</h2>
                                <h3 class="mb-2">Total Pendapatan : {{"Rp ".number_format($total,0,",",".")  }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding-right: 25px;padding-left: 25px;">
                        <!-- Projects table -->
                        <table id="table_import" class="table align-items-center table-striped table-bordered" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">No. Bukti</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Tanggal Penerimaan</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Sub 2 Kategori</th>
                                        <th scope="col">Sub Kategori</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Diinput</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Action</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= sizeof($pendapatans); $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $pendapatans[$i-1]->no_bukti }}</td>
                                            <td> {{ $pendapatans[$i-1]->nama_trans}}</td>
                                            <td>  {{"Rp ".number_format($pendapatans[$i-1]->nominal,0,",",".")  }}</td>
                                            <td> {{ $pendapatans[$i-1]->tanggal}}</td>
                                            @if($pendapatans[$i-1]->tipe == 1)
                                                <td>Debit</td>
                                            @else
                                                <td>Kredit</td>
                                            @endif
                                            <td> {{ $pendapatans[$i-1]->keterangan }}</td>
                                            <td> {{ $pendapatans[$i-1]->nama_sub_2 }}</td>
                                            <td> {{ $pendapatans[$i-1]->nama_sub}}</td>
                                            <td> {{ $pendapatans[$i-1]->nama}}</td>
                                            <td> {{ $pendapatans[$i-1]->created_at}}</td>
                                            @if($pendapatans[$i-1]->status == 1)
                                                <td>Aktif</td>
                                            @else
                                                <td>Non Aktif</td>
                                            @endif
                                            <td>
                                                <form action="pendapatan/{{$pendapatans[$i-1]->id_transaksi}}/edit" method="GET">
                                                    <button type="submit" class="btn btn-info" data-container="body" data-toggle="popover" data-color="info" data-placement="top" data-content="Sunting Kategori">
                                                        Sunting
                                                    </button>
                                                </form>   
                                            </td>
                                            <td>
                                                <form action="pendapatan/{{$pendapatans[$i-1]->id_transaksi}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" data-container="body" data-toggle="popover" data-color="danger" data-placement="top" data-content="Hapus Kategori">
                                                        Hapus
                                                      </button>
                                                    </form>  
                                            </td>
                                            <td>
                                                <form action="pendapatan/{{$pendapatans[$i-1]->id_transaksi}}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" data-container="body" data-toggle="popover" data-color="danger" data-placement="top" data-content="Hapus Kategori">
                                                        Detail
                                                    </button>
                                                </form>  
                                            </td>
                                            <td>
                                                <a href="{{url('/detailpendapatan/create/'.$pendapatans[$i-1]->id_transaksi)}}" class="btn btn-success" data-container="body" data-toggle="popover" data-color="info" data-placement="top">Tambah</a> 
                                            </td>
    
                                        
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