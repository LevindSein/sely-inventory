<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'data_barang';
    protected $fillable = ['id_barang','kode_barang','nama_barang','jenis_barang','masa_simpan','satuan','jumlah_barang','updated_at','created_at'];
}
