<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $table = 'pendapatan';
    public $timestamps = false;
    protected $primaryKey = 'id_pendapatan';
}
