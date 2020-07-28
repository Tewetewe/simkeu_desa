<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    public $timestamps = false;
    protected $primaryKey = 'id_detail_transaksi';
}
