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
                        <form action="/sub2kategori" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="example-text-input">Kode (Masukkan Kode Sub 2 Kategori)</label>
                                <input required class="form-control" type="text" name="kode_sub" id="example-text-input" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Sub Kategori (Pilih Sub Kategori yang Tersedia)</label>
                                <select class="form-control" id="drop" name="id_sub_ktg" required>
                                    <option value="" selected disabled hidden>Pilih Sub Kategori</option>
                                    @foreach ($subkategoris as $subkategori)
                                        <option value="{{$subkategori->id_sub_ktg}}">{{ucfirst($subkategori->nama_sub)}}</option>      
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nama Sub 2 Kategori (Masukkan Nama Sub Kategori)</label>
                                <input required class="form-control" type="text" name="nama_sub" id="example-text-input" >
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
                                    <th scope="col">Kode Sub 2</th>
                                    <th scope="col">Nama Sub 2</th>
                                    <th scope="col">Sub Kategori</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= sizeof($sub2kategoris); $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $sub2kategoris[$i-1]->kode_sub_2 }}</td>
                                        <td> {{ $sub2kategoris[$i-1]->nama_sub_2}}</td>
                                        <td> {{ $sub2kategoris[$i-1]->nama_sub}}</td>
                                        <td> {{ $sub2kategoris[$i-1]->nama}}</td>
                                        @if($sub2kategoris[$i-1]->tipe == 1)
                                            <td>Debit</td>
                                        @else
                                            <td>Kredit</td>
                                        @endif
                                        <td> {{ $sub2kategoris[$i-1]->created_at }}</td>
                                        @if($sub2kategoris[$i-1]->status == 1)
                                            <td>Aktif</td>
                                        @else
                                            <td>Non Aktif</td>
                                        @endif
                                        <td>
                                            <form action="sub2kategori/{{$sub2kategoris[$i-1]->id_sub_2}}/edit" method="GET">
                                                <button type="submit" class="btn btn-info" data-container="body" data-toggle="popover" data-color="info" data-placement="top" data-content="Sunting Kategori">
                                                    Sunting
                                                </button>
                                            </form>   
                                        </td>
                                        <td>
                                            <form action="sub2kategori/{{$sub2kategoris[$i-1]->id_sub_2}}" method="POST">
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