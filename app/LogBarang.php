<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogBarang extends Model
{
    protected $table = 'log_barang';
    protected $fillable = ['id_log','id_barang','jumlah_log','tujuan','session','bulan_log','tahun_log','status','updated_at','created_at'];
}
