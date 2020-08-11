<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\Item;
use App\SubKategori;
use App\Sub2Kategori;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::where('status',1)->get();
        return view('item.index', compact('items'));
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
        $items = new Item;
        $items->kode = $request->kode;
        $items->nama_item = $request->nama;
        $items->satuan = $request->satuan;
        $items->harga = $request->harga;
        $items->created_at = date('Y:m:d H:i:s');
        $items->updated_at = date('Y:m:d H:i:s');
        $items->status = 1;
        $items->save();
        return redirect('/item');

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
        $items = Item::find($id);
        return view('item.edit', compact('items'));
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
        $items = Item::find($id);
        $items->kode = $request->kode;
        $items->nama_item = $request->nama;
        $items->satuan = $request->satuan;
        $items->harga = $request->harga;
        $items->updated_at = date('Y:m:d H:i:s');
        $items->save();
        return redirect('/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Item::find($id);
        $items->status = 0;
        $items->save();
        return redirect('/item');
    }
}
