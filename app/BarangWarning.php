<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangWarning extends Model
{
    protected $table = 'barang_warning';
    protected $fillable = ['id_warning','id_barang','jumlah_warning','bulan_exp','updated_at','created_at'];
}
