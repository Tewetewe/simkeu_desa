<?php

namespace App\Http\Controllers;
use App\Transaksi;
use App\Kategori;
use App\SubKategori;
use App\Sub2Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\DetailTransaksi;

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
                    ->select('transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
                    ->take(10)
                    ->get();
        $pengeluarans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->select('transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
                    ->take(10)
                    ->get();
        return view('dashboard',compact('debit','kredit','lastDebit','lastKredit','lastRatio','lastSaldo','saldo','ratio','pendapatans','pengeluarans'));
    }
}
