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
use Session;
 use PDF;

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
        // $pendapatans = DB::table('transaksi')
        //             ->leftJoin('detail_transaksi','detail_transaksi.id_transaksi','=', 'transaksi.id_transaksi')
        //             ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        //             ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        //             ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        //             ->select('transaksi.tanggal','transaksi.no_bukti','transaksi.nama_trans','transaksi.keterangan',
        //                     'transaksi.nominal', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub',
        //                     'sub_2_ktg_transaksi.nama_sub_2', 'detail_transaksi.tanggal_detail', 'detail_transaksi.tanggal_detail','detail_transaksi.no_bukti_detail',
        //                     'detail_transaksi.nama_item','detail_transaksi.satuan','detail_transaksi.jumlah','detail_transaksi.harga','detail_transaksi.subtotal','detail_transaksi.keterangan_detail')
        //             ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
        //             ->orderBy('tanggal','desc')
        //             ->take(10)
        //             ->get();
        $pendapatans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC')
                    ->get();
                $idPendapatan = [];
                foreach ($pendapatans as $pendapatan => $value) {
                    array_push($idPendapatan,$value->id_transaksi);
                }
        $detailPendapatan =  DB::table('detail_transaksi')
        ->whereIn('id_transaksi',$idPendapatan)
        ->where('status',1)
        ->get();
        $count = 0;
        $subtotal = 0;
        foreach ($pendapatans as $pendapatan => $value) {

            $details = [];
            foreach($detailPendapatan as $detail=>$valueDetail){
                if($valueDetail->id_transaksi == $value->id_transaksi){
                    array_push($details,$valueDetail);
                }
            }
            $value->detail_transaksi = $details;
            $subtotal = $subtotal + $value->nominal;
            $value->subtotal = $subtotal;
        }
        $total = DB::table('transaksi')
        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
        ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
        ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
        ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
        ->whereYear('tanggal', $datenow)
        ->sum('nominal');
        return view ('report.pendapatan', compact('datenow','kategoris','pendapatans','total'));
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
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC');
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
            $query->where('transaksi.nama_trans', 'like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $pendapatans = $query->get();
        $idPendapatan = [];
                foreach ($pendapatans as $pendapatan => $value) {
                    array_push($idPendapatan,$value->id_transaksi);
                }
        $detailPendapatan =  DB::table('detail_transaksi')
        ->whereIn('id_transaksi',$idPendapatan)
        ->get();
        $count = 0;
        $subtotal = 0;
        foreach ($pendapatans as $pendapatan => $value) {

            $details = [];
            foreach($detailPendapatan as $detail=>$valueDetail){
                if($valueDetail->id_transaksi == $value->id_transaksi){
                    array_push($details,$valueDetail);
                }
            }
            $value->detail_transaksi = $details;
            $subtotal = $subtotal + $value->nominal;
            $value->subtotal = $subtotal;
        }
        $nominal   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', 1)
                ->where('transaksi.status',1);
            if(!empty($kategori)){
            $nominal->where('transaksi.id_ktg_transaksi', '=', $kategori);
            }
            if(!empty($subkategori)){
            $nominal->where('transaksi.id_sub_ktg', '=', $subkategori);
            }
            if(!empty($sub2kategori)){
            $nominal->where('transaksi.id_sub_2', '=', $sub2kategori);
            }
            if(!empty($nama)){
            $nominal->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nominal->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $total = $nominal->sum('nominal');
        Session::put('kategoriPendapatan', $kategori);
        Session::put('subKategoriPendapatan', $subkategori);
        Session::put('sub2KategoriPendapatan', $sub2kategori);
        Session::put('namaPendapatan', $nama);
        Session::put('startDatePendapatan', $startDate);
        Session::put('endDatePendapatan', $endDate);
        return view('report.pendapatan', compact('pendapatans','kategoris','datenow','kategori','subkategori','sub2kategori','nama', 'startDate','endDate','total'));
    }
    public function reportPendapatanPDF()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $kategori = Session::get('kategoriPendapatan');
        $subkategori = Session::get('subKategoriPendapatan');
        $sub2kategori = Session::get('sub2KategoriPendapatan');
        $nama = Session::get('namaPendapatan');
        $startDate= Session::get('startDatePendapatan');
        $endDate = Session::get('endDatePendapatan');
        if ($startDate == NULL ) {
            $startDate = $datenow;
        }
        else{
            $startDate = $startDate;
        }
        if ($endDate == NULL ) {
            $endDate = $datenow;
        }
        else{
            $endDate = $endDate;
        }
        $query = Transaksi::query()
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('tipe', 1)
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC');
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
            $query->where('transaksi.nama_trans', 'like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $pendapatans = $query->get();
        $idPendapatan = [];
                foreach ($pendapatans as $pendapatan => $value) {
                    array_push($idPendapatan,$value->id_transaksi);
                }
        $detailPendapatan =  DB::table('detail_transaksi')
        ->whereIn('id_transaksi',$idPendapatan)
        ->get();
        $count = 0;
        $subtotal = 0;
        foreach ($pendapatans as $pendapatan => $value) {

            $details = [];
            foreach($detailPendapatan as $detail=>$valueDetail){
                if($valueDetail->id_transaksi == $value->id_transaksi){
                    array_push($details,$valueDetail);
                }
            }
            $value->detail_transaksi = $details;
            $subtotal = $subtotal + $value->nominal;
            $value->subtotal = $subtotal;
        }
        $nominal   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', 1)
                ->where('transaksi.status',1);
            if(!empty($kategori)){
            $nominal->where('transaksi.id_ktg_transaksi', '=', $kategori);
            }
            if(!empty($subkategori)){
            $nominal->where('transaksi.id_sub_ktg', '=', $subkategori);
            }
            if(!empty($sub2kategori)){
            $nominal->where('transaksi.id_sub_2', '=', $sub2kategori);
            }
            if(!empty($nama)){
            $nominal->where('transaksi.nama_trans','like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nominal->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $total = $nominal->sum('nominal');
        $kategoriNama = Kategori::select('nama')->where('id_ktg_transaksi', $kategori)->first();
        $subkategoriNama = SubKategori::select('nama_sub')->where('id_sub_ktg',$subkategori)->first();
        $sub2kategoriNama = Sub2Kategori::select('nama_sub_2')->where('id_sub_2', $sub2kategori)->first();
        $startDateNew = date('d F Y', strtotime($startDate));
        $endDateNew = date('d F Y', strtotime($endDate));
        $nama_file = 'laporan_pendapatan_'.date('Y-m-d').'.pdf';
        // Session::put('kategoriPendapatan', $kategori);
        // Session::put('subKategoriPendapatan', $subkategori);
        // Session::put('sub2KategoriPendapatan', $sub2kategori);
        // Session::put('namaPendapatan', $nama);
        // Session::put('startDatePendapatan', $startDate);
        // Session::put('endDatePendapatan', $endDate);
        $pdf = PDF::loadview('pdf.pendapatan',compact('pendapatans','kategoriNama','subkategoriNama','sub2kategoriNama','nama', 'startDateNew','endDateNew','total'));
	    return $pdf->stream($nama_file);
    }
    public function reportPengeluaran()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $kategoris = Kategori::where('tipe', -1)->where('status',1)->get();
        $pengeluarans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC')
                    ->get();
                    $idPengeluaran = [];
                    foreach ($pengeluarans as $pengeluaran => $value) {
                        array_push($idPengeluaran,$value->id_transaksi);
                    }
            $detailPengeluaran =  DB::table('detail_transaksi')
            ->whereIn('id_transaksi',$idPengeluaran)
            ->get();
            $count = 0;
            $subtotal = 0;
            foreach ($pengeluarans as $pengeluaran => $value) {
    
                $details = [];
                foreach($detailPengeluaran as $detail=>$valueDetail){
                    if($valueDetail->id_transaksi == $value->id_transaksi){
                        array_push($details,$valueDetail);
                    }
                }
                $value->detail_transaksi = $details;
                $subtotal = $subtotal + $value->nominal;
                $value->subtotal = $subtotal;
            }
        $total = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('ktg_transaksi.tipe', -1)->where('transaksi.status',1)
                    ->whereYear('tanggal', $datenow)
                    ->sum('nominal');
        return view ('report.pengeluaran', compact('datenow','kategoris','pengeluarans','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportPengeluaranFilter(Request $request)
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
                    ->where('tipe', -1)
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC');
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
            $query->where('transaksi.nama_trans', 'like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $pengeluarans = $query->get();
        $idPengeluaran = [];
                    foreach ($pengeluarans as $pengeluaran => $value) {
                        array_push($idPengeluaran,$value->id_transaksi);
                    }
            $detailPengeluaran =  DB::table('detail_transaksi')
            ->whereIn('id_transaksi',$idPengeluaran)
            ->get();
            $count = 0;
            $subtotal = 0;
            foreach ($pengeluarans as $pengeluaran => $value) {
    
                $details = [];
                foreach($detailPengeluaran as $detail=>$valueDetail){
                    if($valueDetail->id_transaksi == $value->id_transaksi){
                        array_push($details,$valueDetail);
                    }
                }
                $value->detail_transaksi = $details;
                $subtotal = $subtotal + $value->nominal;
                $value->subtotal = $subtotal;
            }
        $nominal   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', -1)
                ->where('transaksi.status',1);
            if(!empty($kategori)){
            $nominal->where('transaksi.id_ktg_transaksi', '=', $kategori);
            }
            if(!empty($subkategori)){
            $nominal->where('transaksi.id_sub_ktg', '=', $subkategori);
            }
            if(!empty($sub2kategori)){
            $nominal->where('transaksi.id_sub_2', '=', $sub2kategori);
            }
            if(!empty($nama)){
            $nominal->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nominal->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $total = $nominal->sum('nominal');
        Session::put('kategoriPengeluaran', $kategori);
        Session::put('subKategoriPengeluaran', $subkategori);
        Session::put('sub2KategoriPengeluaran', $sub2kategori);
        Session::put('namaPengeluaran', $nama);
        Session::put('startDatePengeluaran', $startDate);
        Session::put('endDatePengeluaran', $endDate);
        return view('report.pengeluaran', compact('pengeluarans','kategoris','datenow','kategori','subkategori','sub2kategori','nama', 'startDate','endDate','total'));
    }
    public function reportPengeluaranPDF()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $kategori = Session::get('kategoriPengeluaran');
        $subkategori = Session::get('subKategoriPengeluaran');
        $sub2kategori = Session::get('sub2KategoriPengeluaran');
        $nama = Session::get('namaPengeluaran');
        $startDate= Session::get('startDatePengeluaran');
        $endDate = Session::get('endDatePengeluaran');

        if ($startDate == NULL ) {
            $startDate = $datenow;
        }
        else{
            $startDate = $startDate;
        }
        if ($endDate == NULL ) {
            $endDate = $datenow;
        }
        else{
            $endDate = $endDate;
        }


        $query = Transaksi::query()
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('tipe', -1)
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC');
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
            $query->where('transaksi.nama_trans','like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $pengeluarans = $query->get();
        $idPengeluaran = [];
                foreach ($pengeluarans as $pendapatan => $value) {
                    array_push($idPengeluaran,$value->id_transaksi);
                }
        $detailPengeluaran =  DB::table('detail_transaksi')
        ->whereIn('id_transaksi',$idPengeluaran)
        ->where('status',1)
        ->get();
        $count = 0;
        $subtotal = 0;
        foreach ($pengeluarans as $pengeluaran => $value) {

            $details = [];
            foreach($detailPengeluaran as $detail=>$valueDetail){
                if($valueDetail->id_transaksi == $value->id_transaksi){
                    array_push($details,$valueDetail);
                }
            }
            $value->detail_transaksi = $details;
            $subtotal = $subtotal + $value->nominal;
            $value->subtotal = $subtotal;
        }
        $nominal   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', -1)
                ->where('transaksi.status',1);
            if(!empty($kategori)){
            $nominal->where('transaksi.id_ktg_transaksi', '=', $kategori);
            }
            if(!empty($subkategori)){
            $nominal->where('transaksi.id_sub_ktg', '=', $subkategori);
            }
            if(!empty($sub2kategori)){
            $nominal->where('transaksi.id_sub_2', '=', $sub2kategori);
            }
            if(!empty($nama)){
            $nominal->where('transaksi.nama_trans','like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nominal->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $total = $nominal->sum('nominal');
        $kategoriNama = Kategori::select('nama')->where('id_ktg_transaksi', $kategori)->first();
        $subkategoriNama = SubKategori::select('nama_sub')->where('id_sub_ktg',$subkategori)->first();
        $sub2kategoriNama = Sub2Kategori::select('nama_sub_2')->where('id_sub_2', $sub2kategori)->first();
        $startDateNew = date('d F Y', strtotime($startDate));
        $endDateNew = date('d F Y', strtotime($endDate));
        $nama_file = 'laporan_pengeluaran_'.date('Y-m-d').'.pdf';


        // Session::put('kategoriPengeluaran', $kategori);
        // Session::put('subKategoriPengeluaran', $subkategori);
        // Session::put('sub2KategoriPengeluaran', $sub2kategori);
        // Session::put('namaPengeluaran', $nama);
        // Session::put('startDatePengeluaran', $startDate);
        // Session::put('endDatePengeluaran', $endDate);
        $pdf = PDF::loadview('pdf.pengeluaran',compact('pengeluarans','kategoriNama','subkategoriNama','sub2kategoriNama','nama', 'startDateNew','endDateNew','total'));
	    return $pdf->stream($nama_file);
    }
    public function reportTransaksi()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $transaksis = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC')
                    ->get();
                    $idTransaksi = [];
                    foreach ($transaksis as $transaksi => $value) {
                        array_push($idTransaksi,$value->id_transaksi);
                    }
            $detailTransaksi =  DB::table('detail_transaksi')
            ->whereIn('id_transaksi',$idTransaksi)
            ->get();
            $count = 0;
            $subtotal = 0;
            foreach ($transaksis as $transaksi => $value) {

                $details = [];
                foreach($detailTransaksi as $detail=>$valueDetail){
                    if($valueDetail->id_transaksi == $value->id_transaksi){
                        array_push($details,$valueDetail);
                    }
                }
                $value->detail_transaksi = $details;
                $subtotal = $subtotal + $value->nominal;
                $value->subtotal = $subtotal;
            }
        $total = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('transaksi.status',1)
                    ->whereYear('tanggal', $datenow)
                    ->sum('nominal');
        $totalPendapatan = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('transaksi.status',1)
                    ->where('tipe', 1)
                    ->whereYear('tanggal', $datenow)
                    ->sum('nominal');
        $totalPengeluaran = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('transaksi.status',1)
                    ->where('tipe', -1)
                    ->whereYear('tanggal', $datenow)
                    ->sum('nominal');
        return view ('report.rekap', compact('datenow','transaksis','total','totalPendapatan','totalPengeluaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportTransaksiFilter(Request $request)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        $nama = $request->nama;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Transaksi::query()
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC');
        
        if(!empty($nama)){
                $query->where('transaksi.nama_trans',  'like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $transaksis = $query->get();
        $idTransaksi = [];
                    foreach ($transaksis as $transaksi => $value) {
                        array_push($idTransaksi,$value->id_transaksi);
                    }
            $detailTransaksi =  DB::table('detail_transaksi')
            ->whereIn('id_transaksi',$idTransaksi)
            ->get();
            $count = 0;
            $subtotal = 0;
            foreach ($transaksis as $transaksi => $value) {
    
                $details = [];
                foreach($detailTransaksi as $detail=>$valueDetail){
                    if($valueDetail->id_transaksi == $value->id_transaksi){
                        array_push($details,$valueDetail);
                    }
                }
                $value->detail_transaksi = $details;
                $subtotal = $subtotal + $value->nominal;
                $value->subtotal = $subtotal;
            }
        $nominal   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('transaksi.status',1);
            if(!empty($nama)){
                    $nominal->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nominal->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $total = $nominal->sum('nominal');
        $pendapatan   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', 1)
                ->where('transaksi.status',1);
            if(!empty($nama)){
                    $pendapatan->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $pendapatan->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $totalPendapatan = $pendapatan->sum('nominal');
        $pengeluaran   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', -1)
                ->where('transaksi.status',1);
            if(!empty($nama)){
                    $pengeluaran->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $pengeluaran->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $totalPengeluaran = $pengeluaran->sum('nominal');
        Session::put('startDateTransaksi', $startDate);
        Session::put('endDateTransaksi', $endDate);
        Session::put('namaTransaksi', $nama);

        return view('report.rekap', compact('transaksis','datenow', 'startDate','endDate','total','totalPendapatan','totalPengeluaran','nama'));
    }
    public function reportTransaksiPdf(Request $request)
    {
        $startDate= Session::get('startDateTransaksi');
        $endDate = Session::get('endDateTransaksi');
        $nama = Session::get('namaTransaksi');

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        if ($startDate == NULL ) {
            $startDate = $datenow;
        }
        else{
            $startDate = $startDate;
        }
        if ($endDate == NULL ) {
            $endDate = $datenow;
        }
        else{
            $endDate = $endDate;
        }
  

        $query = Transaksi::query()
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->where('transaksi.status',1)
                    ->orderBy('tanggal','ASC');
        if(!empty($nama)){
            $query->where('transaksi.nama_trans', 'like', "%".$nama."%");
        }
        if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $query->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
          
        }
        $transaksis = $query->get();
        $idTransaksi = [];
                    foreach ($transaksis as $transaksi => $value) {
                        array_push($idTransaksi,$value->id_transaksi);
                    }
            $detailTransaksi =  DB::table('detail_transaksi')
            ->whereIn('id_transaksi',$idTransaksi)
            ->where('status',1)
            ->get();
            $count = 0;
            $subtotal = 0;
            foreach ($transaksis as $transaksi => $value) {
    
                $details = [];
                foreach($detailTransaksi as $detail=>$valueDetail){
                    if($valueDetail->id_transaksi == $value->id_transaksi){
                        array_push($details,$valueDetail);
                    }
                }
                $value->detail_transaksi = $details;
                $subtotal = $subtotal + $value->nominal;
                $value->subtotal = $subtotal;
            }
        $nominal   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('transaksi.status',1);
                if(!empty($nama)){
                    $nominal->where('transaksi.nama_trans', 'like', "%".$nama."%");
                }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $nominal->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $total = $nominal->sum('nominal');
        $pendapatan   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', 1)
                ->where('transaksi.status',1);
            if(!empty($nama)){
                    $pendapatan->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $pendapatan->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $totalPendapatan = $pendapatan->sum('nominal');
        $pengeluaran   = Transaksi::query()
                ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                ->where('tipe', -1)
                ->where('transaksi.status',1);
            if(!empty($nama)){
                    $pengeluaran->where('transaksi.nama_trans', 'like', "%".$nama."%");
            }
            if(!empty($startDate) && ($endDate)){
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $pengeluaran->whereDate('transaksi.tanggal','<=',$end->format('Y-m-d'))
            ->whereDate('transaksi.tanggal','>=',$start->format('Y-m-d'));
        }
        $totalPengeluaran = $pengeluaran->sum('nominal');
        $startDateNew = date('d F Y', strtotime($startDate));
        $endDateNew = date('d F Y', strtotime($endDate));
        $nama_file = 'laporan_rekap_'.date('Y-m-d').'.pdf';


        $pdf = PDF::loadview('pdf.rekap',compact('transaksis', 'startDateNew','endDateNew','total','totalPendapatan','totalPengeluaran','nama'));
	    return $pdf->stream($nama_file);
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
