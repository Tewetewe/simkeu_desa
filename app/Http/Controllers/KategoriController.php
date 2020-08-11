<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = Kategori::where('status',1)->get();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        $kategoris = new Kategori;
        $kategoris->kode = $request->kode;
        $kategoris->nama = $request->nama;
        $kategoris->tipe = $request->tipe;
        $kategoris->created_at = date('Y-m-d H:i:s');
        $kategoris->updated_at = date('Y-m-d H:i:s');
        $kategoris->status = 1;
        $kategoris->save();
        return redirect('/kategori');
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
        $kategoris = Kategori::find($id);
        return view('kategori.edit', compact('kategoris'));
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
        $kategoris = Kategori::find($id);
        $kategoris->kode = $request->kode;
        $kategoris->nama = $request->nama;
        $kategoris->tipe = $request->tipe;
        $kategoris->updated_at = date("Y:m:d H:i:s");
        $kategoris->save();
        return redirect('/kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoris = Kategori::find($id);
        $kategoris->status = 0;
        $kategoris->save();
        return redirect('/kategori');
        
    }
}
