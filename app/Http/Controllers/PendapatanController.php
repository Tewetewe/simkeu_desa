<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pendapatan;
use App\Kategori;
use App\SubKategori;
use App\Sub2Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendapatans = DB::table('pendapatan')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'pendapatan.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','pendapatan.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','pendapatan.id_sub_2')
                    ->select('pendapatan.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('pendapatan.status',1)
                    ->get();
        return view('pendapatan.index', compact('pendapatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('m/d/Y');
        $kategoris = Kategori::where('tipe', 1)->where('status',1)->get();
        // $subkategoris = DB::table('sub_ktg_transaksi')
        //                 ->join('ktg_transaksi','ktg_transaksi.id_ktg_transaksi', '=', 'sub_ktg_transaksi.id_ktg_transaksi')
        //                 ->select('sub_ktg_transaksi.id_sub_ktg','sub_ktg_transaksi.nama_sub')
        //                 ->where('ktg_transaksi.tipe', 1)->where('sub_ktg_transaksi.status', 1)->get();
        // $sub2kategoris = DB::table('sub_2_ktg_transaksi')
        //                 ->join('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','sub_2_ktg_transaksi.id_sub_ktg')
        //                 ->join('ktg_transaksi','ktg_transaksi.id_ktg_transaksi', '=', 'sub_ktg_transaksi.id_ktg_transaksi')
        //                 ->select('sub_2_ktg_transaksi.id_sub_2','sub_2_ktg_transaksi.nama_sub_2')
        //                 ->where('ktg_transaksi.tipe', 1)->where('sub_2_ktg_transaksi.status',1)->get();
        return view ('pendapatan.create', compact('datenow','kategoris'));
    }
    public function findSubKategori($id)
    {
        $subkategori = SubKategori::where('id_ktg_transaksi',$id)->where('sub_ktg_transaksi.status', 1)->get();
        return response()->json($subkategori);
    }
    public function findSub2Kategori($id){
        $sub2kategori = Sub2Kategori::where('id_sub_ktg',$id)->get();
        return response()->json($sub2kategori);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $tanggal = $request->tanggal;
        $tgl = Carbon::parse($tanggal);
        $pendapatan = new Pendapatan;
        $pendapatan->id_ktg_transaksi = $request->kategori;
        if($request->subkategori != ''){
            $pendapatan->id_sub_ktg = $request->subkategori;
        }
        if($request->sub2kategori != ''){
            $pendapatan->id_sub_2 = $request->sub2kategori;
        }
        $pendapatan->no_bukti = $request->nobukti;
        $pendapatan->nama_pend = $request->nama;
        $pendapatan->nominal = $request->nominal;
        $pendapatan->keterangan = $request->keterangan;
        $pendapatan->tanggal = $tgl->format('Y-m-d');
        $pendapatan->id_user = auth()->user()->id_user;
        $pendapatan->created_at = date('Y-m-d H:i:s');
        $pendapatan->updated_at = date('Y-m-d H:i:s');
        $pendapatan->status = 1;
        $pendapatan->save();
        return redirect('pendapatan/create');
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
        $pendapatan = DB::table('pendapatan')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'pendapatan.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','pendapatan.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','pendapatan.id_sub_2')
                    ->select('pendapatan.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('pendapatan.id_pendapatan',$id)
                    ->first();
        $kategoris = Kategori::where('tipe', 1)->where('status',1)->get();
        return view('pendapatan.edit', compact('pendapatan', 'kategoris'));
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
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $tanggal = $request->tanggal;
        $tgl = Carbon::parse($tanggal);
        $pendapatan = Pendapatan::find($id);
        $pendapatan->id_ktg_transaksi = $request->kategori;
        $pendapatan->id_sub_ktg = $request->subkategori;
        $pendapatan->id_sub_2 = $request->sub2kategori;
        $pendapatan->no_bukti = $request->nobukti;
        $pendapatan->nama_pend = $request->nama;
        $pendapatan->nominal = $request->nominal;
        $pendapatan->keterangan = $request->keterangan;
        $pendapatan->tanggal = $tgl->format('Y-m-d');
        $pendapatan->id_user = auth()->user()->id_user;
        $pendapatan->updated_at = date('Y-m-d H:i:s');
        $pendapatan->save();
        return redirect('/pendapatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendapatan = Pendapatan::find($id);
        $pendapatan->status = 0;
        $pendapatan->save();
        return redirect('/pendapatan');
    }
}
