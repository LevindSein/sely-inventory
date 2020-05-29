<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangBaik extends Model
{
    protected $table = 'barang_baik';
    protected $fillable = ['id_baik','id_barang','jumlah_baik','bulan_warning','exp','updated_at','created_at'];
}
