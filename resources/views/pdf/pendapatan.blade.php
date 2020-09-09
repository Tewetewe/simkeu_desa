<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laporan Pendapatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 7pt;
		}
	</style>
	<center>
		<h4>Laporan Pendapatan Desa Adat Ketewel</h4>
        <h5>{{$kategoriNama != '' || $kategoriNama != NULL ? $kategoriNama->nama : 'Rekap Semua Pendapatan Desa Adat' }}</h5>
        <h6>{{$subkategoriNama != '' || $subkategoriNama != NULL ? $subkategoriNama->nama_sub : '' }}</h6>
        <h6>{{$sub2kategoriNama != '' || $sub2kategoriNama != NULL ? $sub2kategoriNama->nama_sub_2 : '' }}</h6>
        <h6>{{$nama != '' || $nama != NULL ? $nama : '' }}</h6>
         <h5>{{$startDateNew}} - {{$endDateNew}}</h5>

    </center>
  
    <div class="mt-7">
        <h6> <b> Total Pendapatan : {{"Rp ".number_format($total,0,",",".")  }} </b></h6>
    </div>
    <div class="table-responsive">
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Bukti</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jml</th>
                    <th scope="col">Sat</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Total</th>
                    <th scope="col">Akumulasi</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= sizeof($pendapatans); $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td> {{$pendapatans[$i-1]->tanggal}}</td>
                        <td>{{ $pendapatans[$i-1]->no_bukti}}</td>
                        <td>{{ $pendapatans[$i-1]->nama_trans}}</td>
                        <td>{{''}}</td>
                        <td>{{''}}</td>
                        <td>{{''}}</td>
                        <td>{{''}}</td>
                        <td>  {{number_format($pendapatans[$i-1]->nominal,0,",",".")  }}</td>
                        <td>  {{number_format($pendapatans[$i-1]->subtotal,0,",",".")  }}</td>
                        <td> {{ $pendapatans[$i-1]->keterangan }}</td>
                    
                    </tr>
                    @for ($j = 0; $j < sizeof($pendapatans[$i-1]->detail_transaksi); $j++)
                        <tr>
                        <td>{{ $i }}.{{$j+1}}</td>
                            <td>
                                {{$pendapatans[$i-1]->detail_transaksi[$j]->tanggal_detail}}
                            </td>
                            <td>{{ $pendapatans[$i-1]->detail_transaksi[$j]->no_bukti_detail}}</td>
                            <td>{{ $pendapatans[$i-1]->detail_transaksi[$j]->nama_item}}</td>
                            <td>{{$pendapatans[$i-1]->detail_transaksi[$j]->jumlah}}</td>
                            <td>{{$pendapatans[$i-1]->detail_transaksi[$j]->satuan}}</td>
                            <td>{{number_format($pendapatans[$i-1]->detail_transaksi[$j]->harga,0,",",".")  }}</td>
                            <td>  {{number_format($pendapatans[$i-1]->detail_transaksi[$j]->subtotal,0,",",".")  }}
                            <td>  {{''}}</td>
                            <td>  {{''}}</td>
                            <td> {{ $pendapatans[$i-1]->detail_transaksi[$j]->keterangan_detail }}</td>
                        </tr>
                    @endfor
                @endfor
            </tbody>
        </table>
        <style>
            .table-bordered td, .table-bordered tr, .table-bordered th{
                border-color: black !important;
            }
        </style>
        
    </div>
 
</body>
</html>