<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'ktg_transaksi';
    public $timestamps = false;
    protected $primaryKey = 'id_ktg_transaksi';
}
