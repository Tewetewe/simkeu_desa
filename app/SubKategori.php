<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table = 'sub_ktg_transaksi';
    public $timestamps = false;
    protected $primaryKey = 'id_sub_ktg';
}
