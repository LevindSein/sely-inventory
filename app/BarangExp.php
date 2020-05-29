<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangExp extends Model
{
    protected $table = 'barang_exp';
    protected $fillable = ['id_exp','id_barang','jumlah_exp','updated_at','created_at'];
}
