<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laporan Pengeluaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 8pt;
		}
	</style>
	<center>
		<h4>Laporan Pengeluaran Desa Adat Ketewel</h4>
        <h5>{{$kategoriNama != '' || $kategoriNama != NULL ? $kategoriNama->nama : 'Rekap Semua Pengeluaran Desa Adat' }}</h5>
        <h6>{{$subkategoriNama != '' || $subkategoriNama != NULL ? $subkategoriNama->nama_sub : '' }}</h6>
        <h6>{{$sub2kategoriNama != '' || $sub2kategoriNama != NULL ? $sub2kategoriNama->nama_sub_2 : '' }}</h6>
        <h6>{{$nama != '' || $nama != NULL ? $nama : '' }}</h6>
         <h5>{{$startDateNew}} - {{$endDateNew}}</h5>

    </center>
    <div>
        <h6>{{''}}</h6>
    </div>
    <div>
        <h6> <b> Total Pengeluaran : {{"Rp ".number_format($total*-1,0,",",".")  }} </b></h6>
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
                @for ($i = 1; $i <= sizeof($pengeluarans); $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td> {{$pengeluarans[$i-1]->tanggal}}</td>
                        <td>{{ $pengeluarans[$i-1]->no_bukti}}</td>
                        <td>{{ $pengeluarans[$i-1]->nama_trans}}</td>
                        <td>{{''}}</td>
                        <td>{{''}}</td>
                        <td>{{''}}</td>
                        <td>{{''}}</td>
                        <td>  {{number_format($pengeluarans[$i-1]->nominal*-1,0,",",".")  }}</td>
                        <td>  {{number_format($pengeluarans[$i-1]->subtotal*-1,0,",",".")  }}</td>
                        <td> {{ $pengeluarans[$i-1]->keterangan }}</td>
                    
                    </tr>
                    @for ($j = 0; $j < sizeof($pengeluarans[$i-1]->detail_transaksi); $j++)
                        <tr>
                        <td>{{ $i }}.{{$j+1}}</td>
                            <td>
                                {{$pengeluarans[$i-1]->detail_transaksi[$j]->tanggal_detail}}
                            </td>
                            <td>{{ $pengeluarans[$i-1]->detail_transaksi[$j]->no_bukti_detail}}</td>
                            <td>{{ $pengeluarans[$i-1]->detail_transaksi[$j]->nama_item}}</td>
                            <td>{{$pengeluarans[$i-1]->detail_transaksi[$j]->jumlah}}</td>
                            <td>{{$pengeluarans[$i-1]->detail_transaksi[$j]->satuan}}</td>
                            <td>{{number_format($pengeluarans[$i-1]->detail_transaksi[$j]->harga*-1,0,",",".")  }}</td>
                            <td>  {{number_format($pengeluarans[$i-1]->detail_transaksi[$j]->subtotal*-1,0,",",".")  }}
                            <td>  {{''}}</td>
                            <td>  {{''}}</td>
                            <td> {{ $pengeluarans[$i-1]->detail_transaksi[$j]->keterangan_detail }}</td>
                        </tr>
                    @endfor
                @endfor
            </tbody>
        </table>
    </div>
 
</body>
</html>