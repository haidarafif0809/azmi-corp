<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiGasKeluar extends Model
{
    //
    protected $fillable = [
      'produk_id',
      'nama',
      'kode_produk',
      'kosong_p',
      'harga_kosong_p',
      'kosong_r',
      'harga_kosong_r',
      'kosong_k',
      'isi',
      'harga_isi',
      'no_rute',
      'transaksi_gas_id'
    ];
}
