<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Kategori;
use App\SubKategori;
use App\Sub2Kategori;
use App\DetailTransaksi;

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
        $pendapatans = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->select('transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('ktg_transaksi.tipe', 1)->where('transaksi.status',1)
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
        $datenow = date('Y-m-d');
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
        $pendapatan = new Transaksi;
        $pendapatan->id_ktg_transaksi = $request->kategori;
        if($request->subkategori != ''){
            $pendapatan->id_sub_ktg = $request->subkategori;
        }
        if($request->sub2kategori != ''){
            $pendapatan->id_sub_2 = $request->sub2kategori;
        }
        $pendapatan->no_bukti = $request->nobukti;
        $pendapatan->nama_trans = $request->nama;
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
        $detailtransaksis = DB::table('transaksi')
                        ->join('detail_transaksi','detail_transaksi.id_transaksi','=','transaksi.id_transaksi')
                        ->select('transaksi.id_transaksi','transaksi.nama_trans','transaksi.no_bukti','transaksi.tanggal', 'detail_transaksi.*')
                        ->where('transaksi.id_transaksi', $id)
                        ->where('detail_transaksi.status',1)
                        ->get();
        return view('detailpendapatan.index', compact('detailtransaksis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pendapatan = DB::table('transaksi')
                    ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi', '=', 'transaksi.id_ktg_transaksi')
                    ->LeftJoin('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','transaksi.id_sub_ktg')
                    ->LeftJoin('sub_2_ktg_transaksi','sub_2_ktg_transaksi.id_sub_2','=','transaksi.id_sub_2')
                    ->select('transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe', 'sub_ktg_transaksi.nama_sub','sub_2_ktg_transaksi.nama_sub_2')
                    ->where('transaksi.id_transaksi',$id)
                    ->first();
        $kategoris = Kategori::where('tipe', 1)->where('status',1)->get();
        return view('pendapatan.edit', compact('pendapatan', 'kategoris'));
    }

    public function createDetail($id)
    {
        $transaksi = Transaksi::find($id);
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datenow = date('Y-m-d');
        return view ('detailpendapatan.create', compact('datenow','transaksi'));
    }

    public function storeDetail(Request $request, $id)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $tanggal = $request->tanggal;
        $tgl = Carbon::parse($tanggal);
        $detailtransaksi = new DetailTransaksi;
        $detailtransaksi->no_bukti_detail = $request->nobukti;
        $detailtransaksi->nama_item = $request->nama;
        $detailtransaksi->satuan = $request->satuan;
        $detailtransaksi->jumlah = $request->jumlah;
        $detailtransaksi->harga = $request->harga;
        $detailtransaksi->subtotal = ($request->harga)*($request->jumlah);
        $detailtransaksi->id_transaksi = $id;
        $detailtransaksi->tanggal_detail= $tgl->format('Y-m-d');
        $detailtransaksi->keterangan = $request->keterangan;
        $detailtransaksi->created_at = date('Y-m-d H:i:s');
        $detailtransaksi->updated_at = date('Y-m-d H:i:s');
        $detailtransaksi->status = 1;
        $detailtransaksi->save();
        $total = DB::table('detail_transaksi')
                ->where('detail_transaksi.id_transaksi',$id)
                ->where('detail_transaksi.status',1)
                ->sum('subtotal');
        $updateTotal = Transaksi::find($id);
        $updateTotal->nominal = $total;
        $updateTotal->save();
        return redirect()->to('pendapatan/'.$id);
    }
    public function editDetail($id)
    {
        $detailtransaksi = DetailTransaksi::find($id);
        return view('detailpendapatan.edit', compact('detailtransaksi'));
    }

    public function updateDetail(Request $request, $id)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $tanggal = $request->tanggal;
        $tgl = Carbon::parse($tanggal);
        $detailtransaksi = DetailTransaksi::find($id);
        $detailtransaksi->no_bukti_detail = $request->nobukti;
        $detailtransaksi->nama_item = $request->nama;
        $detailtransaksi->satuan = $request->satuan;
        $detailtransaksi->jumlah = $request->jumlah;
        $transaksi = $detailtransaksi->id_transaksi;
        $detailtransaksi->harga = $request->harga;
        $detailtransaksi->subtotal = ($request->harga)*($request->jumlah);
        $detailtransaksi->tanggal_detail= $tgl->format('Y-m-d');
        $detailtransaksi->keterangan = $request->keterangan;
        $detailtransaksi->created_at = date('Y-m-d H:i:s');
        $detailtransaksi->updated_at = date('Y-m-d H:i:s');
        $detailtransaksi->status = 1;
        $detailtransaksi->save();
        $total = DB::table('detail_transaksi')
                ->where('detail_transaksi.id_transaksi',$transaksi)
                ->where('detail_transaksi.status',1)
                ->sum('subtotal');
        $updateTotal = Transaksi::find($transaksi);
        $updateTotal->nominal = $total;
        $updateTotal->save();
        return redirect()->to('pendapatan/'.$transaksi);
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

        $pendapatan = Transaksi::find($id);
        $pendapatan->id_ktg_transaksi = $request->kategori;
        $pendapatan->id_sub_ktg = $request->subkategori;
        $pendapatan->id_sub_2 = $request->sub2kategori;
        $pendapatan->no_bukti = $request->nobukti;
        $pendapatan->nama_trans = $request->nama;
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
        $pendapatan = Transaksi::find($id);
        $pendapatan->status = 0;
        $pendapatan->save();
        return redirect('/pendapatan');
    }
    public function destroyDetail($id)
    {
        $detailtransaksi = DetailTransaksi::find($id);
        $transaksi = $detailtransaksi->id_transaksi;
        $detailtransaksi->status = 0;
        $detailtransaksi->save();
        return redirect()->to('pendapatan/'.$transaksi);
    }
}
