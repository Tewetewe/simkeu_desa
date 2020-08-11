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
                        <form action="/item" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="example-text-input">Kode (Masukkan Item)</label>
                                <input required class="form-control" type="text" name="kode" id="example-text-input" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nama Item (Masukkan Nama Item)</label>
                                <input required class="form-control" type="text" name="nama" id="example-text-input" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Pilih Satuan (Pilih Satuan yang Tersedia)</label>
                                <select class="form-control" id="drop" name="satuan" required>
                                    <option value="" selected disabled hidden>Pilih Kategori</option>
                                    <option value="pcs">pcs</option>
                                    <option value="lusin">lusin</option>
                                    <option value="dus">dus</option>
                                    <option value="meter">meter</option>
                                    <option value="buah">buah</option>
                                    <option value="pepel">pepel</option>
                                    <option value="bulan">bulan</option>
                                    <option value="orang">orang</option>
                                    <option value="liter">liter</option>
                                    <option value="orang">orang</option>
                                    <option value="kodi">kodi</option>
                                    <option value="hari">hari</option>
                                    <option value="tahun">tahun</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Harga Satuan (Masukkan Harga Satuan)</label>
                                <input required class="form-control" type="number" name="harga" id="example-text-input" >
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

            
                <!-- Form Cari Data Dunia -->
                    


                <div class="table-responsive" style="padding-right: 25px;padding-left: 25px;">
                    <!-- Projects table -->
                    <table id="table_import" class="table align-items-center table-striped table-bordered" cellspacing="0" width="100%">
                        <thead class="thead-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama Item</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= sizeof($items); $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $items[$i-1]->kode }}</td>
                                        <td> {{ $items[$i-1]->nama_item}}</td>
                                        <td> {{ $items[$i-1]->satuan}}</td>
                                        <td> {{ $items[$i-1]->harga}}</td>
                                        <td> {{ $items[$i-1]->created_at }}</td>
                                        @if($items[$i-1]->status == 1)
                                            <td>Aktif</td>
                                        @else
                                            <td>Non Aktif</td>
                                        @endif
                                        <td>
                                            <form action="item/{{$items[$i-1]->id_master_item}}/edit" method="GET">
                                                <button type="submit" class="btn btn-info" data-container="body" data-toggle="popover" data-color="info" data-placement="top" data-content="Sunting Kategori">
                                                    Sunting
                                                </button>
                                            </form>   
                                        </td>
                                        <td>
                                            <form action="item/{{$items[$i-1]->id_master_item}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" data-container="body" data-toggle="popover" data-color="danger" data-placement="top" data-content="Hapus Kategori">
                                                    Hapus
                                                  </button>
                                                </form>  
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