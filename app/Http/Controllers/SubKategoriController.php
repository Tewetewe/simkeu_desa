<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\SubKategori;
use Illuminate\Support\Facades\DB;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = Kategori::where('status',1)->get();
        $subkategoris = DB::table('sub_ktg_transaksi')
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi','=','sub_ktg_transaksi.id_ktg_transaksi')
                        ->select('sub_ktg_transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe')
                        ->where('sub_ktg_transaksi.status',1)
                        ->get();
        return view ('subkategori.index', compact('kategoris','subkategoris'));
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
        $subkategoris = new SubKategori;
        $subkategoris->kode_sub = $request->kode_sub;
        $subkategoris->id_ktg_transaksi = $request->id_ktg_transaksi;
        $subkategoris->nama_sub = $request->nama_sub;
        $subkategoris->created_at = date('Y:m:d H:i:s');
        $subkategoris->updated_at = date('Y:m:d H:i:s');
        $subkategoris->status = 1;
        $subkategoris->save();
        return redirect('/subkategori');
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
        $kategoris = Kategori::where('status', 1)->get();
        $subkategoris = DB::table('sub_ktg_transaksi')->where('id_sub_ktg',$id)
                        ->join('ktg_transaksi', 'ktg_transaksi.id_ktg_transaksi','=','sub_ktg_transaksi.id_ktg_transaksi')
                        ->select('sub_ktg_transaksi.*', 'ktg_transaksi.nama', 'ktg_transaksi.tipe')
                       ->first();
        return view('subkategori.edit', compact('subkategoris','kategoris'));
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
        $subkategoris = SubKategori::find($id);
        $subkategoris->kode_sub = $request->kode_sub;
        $subkategoris->id_ktg_transaksi = $request->id_ktg_transaksi;
        $subkategoris->nama_sub = $request->nama_sub;
        $subkategoris->updated_at = date('Y:m:d H:i:s');
        $subkategoris->save();
        return redirect('/subkategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subkategoris = SubKategori::find($id);
        $subkategoris->status = 0;
        $subkategoris->save();
        return redirect('/subkategori');
    }
}
