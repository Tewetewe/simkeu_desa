<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    public $timestamps = false;
    protected $primaryKey = 'id_pengeluaran';
}
