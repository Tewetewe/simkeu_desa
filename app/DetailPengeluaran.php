<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPengeluaran extends Model
{
    protected $table = 'detail_pengeluaran';
    public $timestamps = false;
    protected $primaryKey = 'id_detail_pengeluaran';
}
