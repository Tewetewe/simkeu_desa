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
                                <h2 class="mb-0">Sub Kategori Pendapatan dan Belanja Desa</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Form Cari Data Dunia -->
                    <div class="p-4 bg-secondary">
                    <form action="/sub2kategori/{{$sub2kategoris->id_sub_2}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <label for="example-text-input">Kode (Masukkan Kode Sub 2 Kategori)</label>
                            <input class="form-control" type="text" name="kode_sub" id="example-text-input" required value="{{$sub2kategoris->kode_sub_2}}">
                            </div>
                          
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Sub Kategori (Pilih Sub Kategori)</label>
                            <select class="form-control" id="drop" name="id_sub_ktg" required value="{{$sub2kategoris->id_sub_ktg}}">
                                {{-- <option value="{{$subkategoris->id_ktg_transaksi}}" >{{$subkategoris->nama}}</option> --}}
                                    @foreach ($subkategoris as $subkategori)
                                        @if($subkategori->id_sub_ktg == $sub2kategoris->id_sub_ktg)
                                            <option selected value="{{$subkategori->id_sub_ktg}}">{{$subkategori->nama_sub}}</option>
                                        @else
                                            <option value="{{$subkategori->id_sub_ktg}}">{{ucfirst($subkategori->nama_sub)}}</option>
                                        @endif    
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Sub 2 Kategori (Masukkan Nama Sub 2 Kategori)</label>
                                <input class="form-control" type="text" name="nama_sub" id="example-text-input" required value="{{$sub2kategoris->nama_sub_2}}" >
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleFormControlSelect1">Status (Pilih Status Sub Kategori)</label>
                            <select class="form-control" id="drop" name="status" required value="{{$subkategoris->status}}">
                                    <option value="1" @if($subkategoris->status==1) selected='selected' @endif>Aktif</option>
                                    <option value="0" @if($subkategoris->status==0) selected='selected' @endif>Non Aktif</option>
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