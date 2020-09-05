<?php

namespace App\Http\Controllers;
use App\Transaksi;
use App\Kategori;
use App\SubKategori;
use App\Sub2Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\DetailTransaksi;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');

        $debit = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->sum('nominal');

        $lastDebit = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->select('nominal')
        ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->orderBy('transaksi.created_at','DESC')
        ->first()->nominal;


        $lastKredit = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->select('nominal')
        ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->orderBy('transaksi.created_at','DESC')
        ->first()->nominal;

        $kredit = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->sum('nominal');
        
        $saldo = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->sum('nominal');

        $lastSaldo = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->select('nominal')
        ->orderBy('transaksi.created_at','DESC')
        ->first()->nominal;
        $ratio = number_format(($debit/$kredit*-1),2);
        $lastRatio = number_format(($debit/$kredit*-1)-(($debit-$lastDebit)/($kredit-$lastKredit)*-1),2);
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y');
        $pendapatans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->select('transaksi.nama_trans', 'transaksi.nominal')
                    ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
                    ->take(10)
                    ->get();
        $pengeluarans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->select('transaksi.nama_trans', 'transaksi.nominal')
                    ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
                    ->take(10)
                    ->get();
            
        
        $dataPendapatanHarian = Transaksi::select(DB::raw('transaksi.tanggal, SUM(transaksi.nominal) as nominal'))
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                        ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
                        ->whereYear('tanggal', $datenow)
                        ->orderBy('transaksi.tanggal','ASC')
                        ->groupBy('transaksi.tanggal')
                        ->get();

        
        $dataPendapatanBulanan = Transaksi::select(DB::raw('MONTH(tanggal) as bulanPendapatan, SUM(transaksi.nominal) as nominal'))
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                        ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
                        ->whereYear('tanggal', $datenow)
                        ->groupBy(DB::raw('MONTH(transaksi.tanggal)'))
                        ->orderBy((DB::raw('MONTH(tanggal)','ASC')))
                        ->get();

        $tanggalPendapatan = array();
        $nominalPendapatan = array();
        for ($i=0; $i < count($dataPendapatanHarian); $i++) {
            array_push($tanggalPendapatan, date('d-F', strtotime($dataPendapatanHarian[$i]->tanggal)));
            array_push($nominalPendapatan, $dataPendapatanHarian[$i]->nominal);
        }

        $tanggalPendapatanBulanan = array();
        $nominalPendapatanBulanan = array();
        for ($i=0; $i < count($dataPendapatanBulanan); $i++) {
            array_push($tanggalPendapatanBulanan,  date('F', mktime(0, 0, 0, $dataPendapatanBulanan[$i]->bulanPendapatan, 10)));
            array_push($nominalPendapatanBulanan, $dataPendapatanBulanan[$i]->nominal);
        }

        $dataPengeluaranHarian = Transaksi::select(DB::raw('transaksi.tanggal, SUM(transaksi.nominal) as nominal'))
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                        ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
                        ->whereYear('tanggal', $datenow)
                        ->orderBy('transaksi.tanggal','ASC')
                        ->groupBy('transaksi.tanggal')
                        ->get();
        
        $dataPengeluaranBulanan = Transaksi::select(DB::raw('MONTH(tanggal) as bulanPengeluaran, SUM(transaksi.nominal) as nominal'))
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                        ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
                        ->whereYear('tanggal', $datenow)
                        ->groupBy( DB::raw('MONTH(transaksi.tanggal)'))
                        ->orderBy((DB::raw('MONTH(tanggal)','ASC')))
                        ->get();

        $tanggalPengeluaran = array();
        $nominalPengeluaran = array();
        for ($i=0; $i < count($dataPengeluaranHarian); $i++) {
            array_push($tanggalPengeluaran, date('d-F', strtotime($dataPengeluaranHarian[$i]->tanggal)));
            array_push($nominalPengeluaran, $dataPengeluaranHarian[$i]->nominal*-1);
        }
        
        $tanggalPengeluaranBulanan = array();
        $nominalPengeluaranBulanan = array();
        for ($i=0; $i < count($dataPengeluaranBulanan); $i++) {
            array_push($tanggalPengeluaranBulanan, date('F', mktime(0, 0, 0, $dataPengeluaranBulanan[$i]->bulanPengeluaran, 10)));
            array_push($nominalPengeluaranBulanan, $dataPengeluaranBulanan[$i]->nominal*-1);
        }
         

        return view('dashboard',compact('debit','kredit','lastDebit','lastKredit','tanggalPendapatan','tanggalPengeluaran','nominalPendapatan','nominalPengeluaran',
        'lastRatio','lastSaldo','saldo','ratio','pendapatans','pengeluarans','tanggalPendapatan','nominalPendapatan','tanggalPengeluaran','nominalPengeluaran','tanggalPendapatanBulanan','nominalPendapatanBulanan','tanggalPengeluaranBulanan','nominalPengeluaranBulanan'));
    }
}
