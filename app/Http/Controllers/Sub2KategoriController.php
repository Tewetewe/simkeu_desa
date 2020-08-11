<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\SubKategori;
use App\Sub2Kategori;
use Illuminate\Support\Facades\DB;

class Sub2KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subkategoris = SubKategori::where('status',1)->get();
        $sub2kategoris = DB::table('sub_2_ktg_transaksi')
                        ->join('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','sub_2_ktg_transaksi.id_sub_ktg')
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi','=','sub_ktg_transaksi.id_ktg_transaksi')
                        ->select('sub_2_ktg_transaksi.*','sub_ktg_transaksi.nama_sub', 'ktg_transaksi.nama', 'ktg_transaksi.tipe')
                        ->where('sub_2_ktg_transaksi.status',1)
                        ->get();
        return view ('sub2kategori.index', compact('subkategoris','sub2kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $sub2kategoris = new Sub2Kategori;
        $sub2kategoris->kode_sub_2 = $request->kode_sub;
        $sub2kategoris->nama_sub_2 = $request->nama_sub;
        $sub2kategoris->id_sub_ktg = $request->id_sub_ktg;
        $sub2kategoris->created_at = date('Y:m:d H:i:s');
        $sub2kategoris->updated_at = date('Y:m:d H:i:s');
        $sub2kategoris->status = 1;
        $sub2kategoris->save();
        return redirect('/sub2kategori');
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
        $subkategoris = SubKategori::where('status', 1)->get();
        $sub2kategoris = DB::table('sub_2_ktg_transaksi')->where('id_sub_2',$id)
                        ->join('sub_ktg_transaksi', 'sub_ktg_transaksi.id_sub_ktg','=','sub_2_ktg_transaksi.id_sub_ktg')
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi','=','sub_ktg_transaksi.id_ktg_transaksi')
                        ->select('sub_2_ktg_transaksi.*','sub_ktg_transaksi.nama_sub', 'ktg_transaksi.nama', 'ktg_transaksi.tipe')
                       ->first();
        return view('sub2kategori.edit', compact('subkategoris','sub2kategoris'));
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
        $sub2kategoris = Sub2Kategori::find($id);
        $sub2kategoris->kode_sub_2 = $request->kode_sub;
        $sub2kategoris->id_sub_ktg = $request->id_sub_ktg;
        $sub2kategoris->nama_sub_2 = $request->nama_sub;
        $sub2kategoris->updated_at = date('Y:m:d H:i:s');
        $sub2kategoris->save();
        return redirect('/sub2kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub2kategoris = Sub2Kategori::find($id);
        $sub2kategoris->status = 0;
        $sub2kategoris->save();
        return redirect('/sub2kategori');
    }
}
