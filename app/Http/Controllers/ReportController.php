<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Kategori;
use App\SubKategori;
use App\Sub2Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\DetailTransaksi;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function findSubKategori($id)
    {
        $subkategori = SubKategori::where('id_ktg_transaksi',$id)->where('sub_ktg_transaksi.status', 1)->get();
        return response()->json($subkategori);
    }
    public function findSub2Kategori($id){
        $sub2kategori = Sub2Kategori::where('id_sub_ktg',$id)->get();
        return response()->json($sub2kategori);

    }
    public function reportPendapatan()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $kategoris = Kategori::where('tipe', 1)->where('status',1)->get();
        $pendapatans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->select('transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
                    ->orderBy('tanggal','desc')
                    ->take(10)
                    ->get();
        return view ('report.pendapatan', compact('datenow','kategoris','pendapatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportPendapatanFilter(Request $request)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $kategoris = Kategori::where('tipe', 1)->where('status',1)->get();
        $kategori = $request->kategori;
        $subkategori = $request->subkategori;
        $sub2kategori = $request->sub2kategori;
        $nama = $request->nama;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Transaksi::query()
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('tipe', 1)
                    ->where('transaksi.status',1);
        if(!empty($kategori)){
            $query->where('transaksi.id_ktg_transaksi', '=', $kategori);
        }
        if(!empty($subkategori)){
            $query->where('transaksi.id_sub_ktg', '=', $subkategori);
        }
        if(!empty($sub2kategori)){
            $query->where('transaksi.id_sub_2', '=', $sub2kategori);
        }
        if(!empty($nama)){
            $query->where('transaksi.nama', 'like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $pendapatans = $query->get();
        // Session::put('namaGlobal', $nama);
        // Session::put('startDateGlobal', $startDate);
        // Session::put('endDateGlobal', $endDate);
        return view('report.pendapatan', compact('pendapatans','kategoris','datenow'));
    }

    /**
     * Store a newly created reurce in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
