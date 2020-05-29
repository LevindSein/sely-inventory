<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HapusBarang extends Model
{
    protected $table = 'delete_barang';
    protected $fillable = ['id_delete','kode_barang','nama_barang','jenis_barang','satuan','jumlah_barang','session','updated_at','created_at'];
}
